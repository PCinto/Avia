<?php
// Weather_Page.php

// Set default location and API configuration
$city = "Nairobi";
$apiKey = "edb92f79783dac274c9131bd452d2945"; // Replace with your valid API key
$units = "metric";

// Build API URL for current weather using city name
$currentUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&units=" . $units . "&appid=" . $apiKey;

// Fetch current weather data
$currentData = file_get_contents($currentUrl);
if ($currentData === FALSE) {
    die("Error fetching current weather data. Please check your API key and endpoint.");
}
$current = json_decode($currentData, true);
if ($current === NULL) {
    die("Error decoding current weather data.");
}
if (isset($current['cod']) && $current['cod'] != 200) {
    $errorMsg = isset($current['message']) ? $current['message'] : 'Unknown error';
    die("API Error (Current): " . htmlspecialchars($errorMsg));
}

// Build API URL for forecast data using city name
$forecastUrl = "https://api.openweathermap.org/data/2.5/forecast?q=" . urlencode($city) . "&units=" . $units . "&appid=" . $apiKey;

// Fetch forecast data
$forecastData = file_get_contents($forecastUrl);
if ($forecastData === FALSE) {
    die("Error fetching forecast data.");
}
$forecast = json_decode($forecastData, true);
if ($forecast === NULL) {
    die("Error decoding forecast data.");
}
if (isset($forecast['cod']) && $forecast['cod'] != "200") {
    $errorMsg = isset($forecast['message']) ? $forecast['message'] : 'Unknown error';
    die("API Error (Forecast): " . htmlspecialchars($errorMsg));
}

// Group forecast data by day (using date as key)
$dailyForecast = [];
foreach ($forecast['list'] as $entry) {
    $date = date("Y-m-d", $entry['dt']);
    if (!isset($dailyForecast[$date])) {
        $dailyForecast[$date] = [];
    }
    $dailyForecast[$date][] = $entry;
}

// For each day, aggregate data: min/max temperature, average humidity, wind, clouds, etc.
$groupedForecast = [];
foreach ($dailyForecast as $date => $entries) {
    $minTemp = PHP_FLOAT_MAX;
    $maxTemp = -PHP_FLOAT_MAX;
    $humiditySum = 0;
    $windSpeedSum = 0;
    $cloudsSum = 0;
    $popSum = 0;
    $descriptions = [];
    $count = count($entries);
    
    foreach ($entries as $entry) {
        $minTemp = min($minTemp, $entry['main']['temp_min']);
        $maxTemp = max($maxTemp, $entry['main']['temp_max']);
        $humiditySum += $entry['main']['humidity'];
        $windSpeedSum += $entry['wind']['speed'];
        $cloudsSum += $entry['clouds']['all'];
        $popSum += $entry['pop'];
        $descriptions[] = $entry['weather'][0]['description'];
    }
    
    // Pick the most common weather description for the day
    $descCount = array_count_values($descriptions);
    arsort($descCount);
    $commonDesc = key($descCount);
    
    // Use the icon from the first entry as a representative
    $groupedForecast[$date] = [
        'minTemp'     => round($minTemp),
        'maxTemp'     => round($maxTemp),
        'avgHumidity' => round($humiditySum / $count),
        'avgWind'     => round($windSpeedSum / $count, 1),
        'avgClouds'   => round($cloudsSum / $count),
        'avgPop'      => round($popSum / $count * 100),
        'description' => ucwords($commonDesc),
        'icon'        => $entries[0]['weather'][0]['icon'],
        'date'        => $date
    ];
}

// Function to format Unix timestamps
function formatTimestamp($timestamp, $format = "D, d M Y H:i") {
    return date($format, $timestamp);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live Weather – Pre-Flight Briefing</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .current-weather {
      background: #004080;
      color: #fff;
      padding: 30px;
      border-radius: 10px;
      margin-bottom: 30px;
    }
    .forecast-day {
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .weather-icon {
      width: 80px;
      height: 80px;
    }
  </style>
</head>
<body>
  <div class="container my-4">
    <header class="mb-4">
      <h1 class="text-center">Live Weather for Pre-Flight Briefing</h1>
      <p class="text-center lead">Current conditions and Forecast for <?php echo htmlspecialchars($city); ?></p>
    </header>

    <!-- Current Weather Section -->
    <section class="current-weather text-center">
      <?php
      // Extract current weather details from $current data array
      $currentIcon = $current['weather'][0]['icon'];
      $currentDesc = ucwords($current['weather'][0]['description']);
      ?>
      <h2>Current Conditions</h2>
      <div class="d-flex justify-content-center align-items-center mb-3">
        <img class="weather-icon me-3" src="http://openweathermap.org/img/wn/<?php echo htmlspecialchars($currentIcon); ?>@2x.png" alt="Weather Icon">
        <div>
          <h3><?php echo htmlspecialchars(round($current['main']['temp'])); ?> °C</h3>
          <p class="mb-0"><?php echo htmlspecialchars($currentDesc); ?></p>
        </div>
      </div>
      <p>
        <strong>Date & Time:</strong> <?php echo formatTimestamp($current['dt']); ?><br>
        <strong>Humidity:</strong> <?php echo htmlspecialchars($current['main']['humidity']); ?>%<br>
        <strong>Pressure:</strong> <?php echo htmlspecialchars($current['main']['pressure']); ?> hPa<br>
        <strong>Wind:</strong> <?php echo htmlspecialchars($current['wind']['speed']); ?> m/s, <?php echo htmlspecialchars($current['wind']['deg']); ?>°<br>
        <strong>Cloudiness:</strong> <?php echo htmlspecialchars($current['clouds']['all']); ?>%<br>
        <strong>Visibility:</strong> <?php echo htmlspecialchars($current['visibility'] / 1000); ?> km<br>
        <strong>Sunrise:</strong> <?php echo formatTimestamp($current['sys']['sunrise'], "H:i"); ?> &nbsp;
        <strong>Sunset:</strong> <?php echo formatTimestamp($current['sys']['sunset'], "H:i"); ?>
      </p>
    </section>

    <!-- Forecast Section -->
    <section>
      <h2 class="mb-4 text-center">Forecast (Daily Summary)</h2>
      <div class="row">
        <?php foreach ($groupedForecast as $date => $day): ?>
          <div class="col-md-4">
            <div class="forecast-day text-center mb-4">
              <h5><?php echo date("D, d M", strtotime($day['date'])); ?></h5>
              <img class="weather-icon" src="http://openweathermap.org/img/wn/<?php echo htmlspecialchars($day['icon']); ?>@2x.png" alt="Icon">
              <p class="mb-1"><strong><?php echo htmlspecialchars($day['description']); ?></strong></p>
              <p class="mb-1">
                <span>Min: <?php echo htmlspecialchars($day['minTemp']); ?> °C</span><br>
                <span>Max: <?php echo htmlspecialchars($day['maxTemp']); ?> °C</span>
              </p>
              <p class="mb-1"><small>Avg Humidity: <?php echo htmlspecialchars($day['avgHumidity']); ?>%</small></p>
              <p class="mb-1"><small>Avg Wind: <?php echo htmlspecialchars($day['avgWind']); ?> m/s</small></p>
              <p class="mb-1"><small>Cloudiness: <?php echo htmlspecialchars($day['avgClouds']); ?>%</small></p>
              <p class="mb-0"><small>Precipitation: <?php echo htmlspecialchars($day['avgPop']); ?>%</small></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="text-muted text-center">Note: Forecast is for the next 5 days as provided by the free API.</p>
    </section>
  </div>

  <!-- Bootstrap JS (optional, for interactive components) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
