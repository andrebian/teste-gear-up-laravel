# Gear Up Laravel Practical Test

## Installing

Clone this repository and install composer dependencies

> This application doesn't need a database connection

## Running

Enter the project folder and run the command:

`php artisan serve`

Acess the address `http://localhost:8000` in your browser 
to see the Laravel's welcome screen.

## Endpoint

`/api/time-calculator`

## Examples

The time calculator was created expecting 3 parameters.

| Parameter     | Type | Complement | Example   |
| :------- | ----: | :---: | :---: |
| start_time | string |  Hour format (HH:ss) | 00:45 |
| end_time    | string   |  Hour format (HH:ss)   | 12:00 |
| quantity     | string    |    | 30 |


`http://localhost:8000/api/time-calculator?start_time=03:00&end_time=23:00&quantity=40`


### Result

```json
{
  "code":200,
  "status":"success",
  "message":"Calculated 40 times between 03:00 and 23:00",
  "content":{
    "time_result":[
      "03:00",
      "03:43",
      "04:13",
      "04:52",
      "05:41",
      "06:05",
      "06:21",
      "06:36",
      "07:11",
      "07:16",
      "07:59",
      "08:31",
      "08:35",
      "09:07",
      "09:12",
      "09:24",
      "09:59",
      "10:52",
      "11:35",
      "12:28",
      "13:25",
      "13:54",
      "14:49",
      "15:20",
      "15:41",
      "16:18",
      "16:47",
      "17:33",
      "17:57",
      "18:49",
      "19:26",
      "20:09",
      "20:15",
      "20:39",
      "20:48",
      "21:40",
      "21:52",
      "22:38",
      "22:53",
      "23:00"
    ],
    "occurrences_per_hour":{
      "09":4,
      "20":4,
      "06":3,
      "07":3,
      "03":2,
      "15":2,
      "22":2,
      "21":2,
      "17":2,
      "16":2,
      "13":2,
      "04":2,
      "08":2,
      "14":1,
      "12":1,
      "11":1,
      "18":1,
      "19":1,
      "10":1,
      "05":1,
      "23":1
    },
    "hour_with_more_occurrences":"09",
    "average_results_per_hour":1.9,
    "smallest_interval":"00:04",
    "greatest_interval":"00:57"
  }
}
```

## Testing

`./vendor/bin/phpunit`

If you have the `xdebug` extension, an html report will be generated in **./build** folder.


## Thanks!