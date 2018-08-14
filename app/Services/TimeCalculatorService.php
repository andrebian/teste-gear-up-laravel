<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 14/08/18
 * Time: 12:21
 */

namespace App\Services;
use App\Models\TimeResult;
use DateInterval;
use DateTime;

/**
 * Class TimeCalculatorService
 * @package App\Services
 */
class TimeCalculatorService
{
    /**
     * @param string $minHour
     * @param string $maxHour
     * @param int $quantity
     * @return TimeResult
     * @throws \Exception
     */
    public function calculate($minHour = '00:00', $maxHour = '23:59', $quantity = 50)
    {
        if ($quantity <= 3) {
            return new TimeResult([
                'code' => 400,
                'status' => 'error',
                'message' => 'The quantity cannot be smaller than \'3\'.'
            ]);
        }

        $minHour = str_pad($minHour, 5, '0', STR_PAD_LEFT);
        $maxHour = str_pad($maxHour, 5, '0', STR_PAD_LEFT);

        $pattern = '/(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]/';

        if (! preg_match($pattern, $minHour)) {
            return new TimeResult([
                'code' => 400,
                'status' => 'error',
                'message' => 'The min time is not a valid time.'
            ]);
        }

        if (! preg_match($pattern, $maxHour)) {
            return new TimeResult([
                'code' => 400,
                'status' => 'error',
                'message' => 'The max time is not a valid time.'
            ]);
        }

        $startDate = new DateTime(date('Y-m-d H:i:s', strtotime($minHour)));
        $endDate = new DateTime(date('Y-m-d H:i:s', strtotime($maxHour)));

        if ($endDate < $startDate) {
            return new TimeResult([
                'code' => 400,
                'status' => 'error',
                'message' => 'The max time is smaller than min time.'
            ]);
        }

        $diff = date_diff($startDate, $endDate);
        $minutesBetweenStartAndEndTime = (int)$diff->format('%H') * 60;

        if ($diff->format('%i') > 0) {
            $minutesBetweenStartAndEndTime += (int)$diff->format('%i');
        }

        if ($minutesBetweenStartAndEndTime < $quantity) {
            return new TimeResult([
                'code' => 400,
                'status' => 'error',
                'message' => 'The expected quantity is greater than the available possibilities.'
            ]);
        }

        $currentDate = new DateTime($startDate->format('Y-m-d H:i:s'));
        $clockResult[] = $startDate->format('H:i');

        for ($current = ($quantity - 1); $current > 1; $current--) {
            $time = $this->appendTime(
                $currentDate,
                rand(1, 59),
                $endDate,
                $startDate
            );
            $clockResult[] = $time;
        }

        $clockResult[] = $endDate->format('H:i');

        asort($clockResult);

        $occurrences = $this->calculateOccurrencesPerHour($clockResult);
        $averageResultPerHour = number_format(($quantity / count($occurrences)), 2, '.', ',');
        $hourWithMoreOccurrences = key($occurrences);
        $hourWithMoreOccurrences = str_pad($hourWithMoreOccurrences, 2, '0', STR_PAD_LEFT);

        $content = [
            'time_result' => $clockResult,
            'occurrences_per_hour' => $occurrences,
            'hour_with_more_occurrences' => $hourWithMoreOccurrences,
            'average_results_per_hour' => (float)$averageResultPerHour,
            'smallest_interval' => $this->calculateInterval('smallest', $clockResult),
            'greatest_interval' => $this->calculateInterval('greatest', $clockResult)
        ];

        $message = 'Calculated ' . $quantity . ' times between ' . $startDate->format('H:i');
        $message .= ' and ' . $endDate->format('H:i');

        return new TimeResult([
            'code' => 200,
            'status' => 'success',
            'message' => $message,
            'content' => $content
        ]);
    }

    /**
     * @param DateTime $currentDate
     * @param $minutesToAdd
     * @param DateTime $finalDate
     * @return string
     * @throws \Exception
     */
    private function appendTime(DateTime &$currentDate, $minutesToAdd, DateTime $finalDate, DateTime $initialDate)
    {
        if ($currentDate >= $finalDate) {
            $currentDate = new DateTime($finalDate->format('Y-m-d H:i:s'));
            $currentDate->sub(new DateInterval('PT' . $minutesToAdd . 'M'));
        } else {
            $currentDate->add(new DateInterval('PT' . $minutesToAdd . 'M'));
            if ($currentDate >= $finalDate) {
                $max = $minutesToAdd * rand(2, 4);
                $minutesToAdd = rand($minutesToAdd, $max);
                $currentDate = new DateTime($finalDate->format('Y-m-d H:i:s'));
                $currentDate->sub(new DateInterval('PT' . $minutesToAdd . 'M'));
            }

            if ($currentDate < $initialDate) {
                $currentDate = new DateTime($initialDate->format('Y-m-d H:i:s'));
                $minutesToAdd = rand(1, 10);
                $currentDate->add(new DateInterval('PT' . $minutesToAdd . 'M'));
            }
        }

        return $currentDate->format('H:i');
    }

    /**
     * @param $clockResult
     * @return array
     */
    private function calculateOccurrencesPerHour($clockResult)
    {
        $result = [];
        foreach ($clockResult as $hourAndMinute) {
            $hourAndMinute = explode(':', $hourAndMinute);
            $hour = $hourAndMinute[0];
            $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);

            if (! array_key_exists($hour, $result)) {
                $result[$hour] = 0;
            }

            $result[$hour]++;
        }

        arsort($result);
        return $result;
    }

    /**
     * @param $type
     * @param array $clockResult
     * @return string
     */
    private function calculateInterval($type, array $clockResult)
    {
        $totalResults = count($clockResult);

        $result = null;
        for ($count = 0; $count < count($clockResult); $count++) {
            if (($count + 1) < $totalResults) {
                $currentDateTime = new DateTime(date('Y-m-d H:i', strtotime($clockResult[$count])));
                $nextDateTime = new DateTime(date('Y-m-d H:i', strtotime($clockResult[($count + 1)])));

                $diff = date_diff($currentDateTime, $nextDateTime);
                $diffMinutes = 0;
                if ($diff->format('%H') > 0) {
                    $diffMinutes = ($diff->format('%H') * 60);
                }
                $diffMinutes += $diff->format('%i');

                switch ($type) {
                    case 'greatest':
                        if ($result === null || $diffMinutes > $result) {
                            $result = $diffMinutes;
                        }
                        break;
                    default:
                        if ($result === null || $diffMinutes < $result) {
                            $result = $diffMinutes;
                        }
                        break;
                }
            }
        }

        $hours = floor($result / 60);
        $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);

        $minutes = ($result % 60);
        $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        return $hours . ':' . $minutes;
    }
}
