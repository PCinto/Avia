<?php
// live_weather.php
// Set your default location (Nairobi) coordinates
$city = "Nairobi";
$lat = "-1.286389";   // Latitude for Nairobi
$lon = "36.817223";   // Longitude for Nairobi
$apiKey = "edb92f79783dac274c9131bd452d2945"; // Replace with your valid OpenWeatherMap API key
$units = "metric"; // Use metric units (°C, m/s)

// API endpoint for One Call API (current and daily forecast)
$apiUrl = "https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&exclude=minutely,hourly,alerts&units={$units}&appid={$apiKey}";

// Fetch data from OpenWeatherMap API
$weatherData = file_get_contents($apiUrl);
if ($weatherData === FALSE) {
    die("Error fetching weather data. Please check your API key and endpoint.");
}
$data = json_decode($weatherData, true);
if ($data === NULL) {
    die("Error decoding weather data.");
}

// Check for API error response
if (isset($data['cod']) && $data['cod'] != 200) {
    $errorMsg = isset($data['message']) ? $data['message'] : 'Unknown error';
    die("API Error ({$data['cod']}): " . htmlspecialchars($errorMsg));
}

// Function to format Unix timestamp into a readable date/time string
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
    body {
      background: #f8f9fa;
    }
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
      <p class="text-center lead">Current conditions and 7‑Day Forecast for <?php echo htmlspecialchars($city); ?></p>
    </header>

    <!-- Current Weather Section -->
    <section class="current-weather text-center">
      <?php
      $current = $data['current'];
      $icon = $current['weather'][0]['icon'];
      $description = ucwords($current['weather'][0]['description']);
      ?>
      <h2>Current Conditions</h2>
      <div class="d-flex justify-content-center align-items-center mb-3">
        <img class="weather-icon me-3" src="http://openweathermap.org/img/wn/<?php echo htmlspecialchars($icon); ?>@2x.png" alt="Weather Icon">
        <div>
          <h3><?php echo htmlspecialchars(round($current['temp'])); ?> °C</h3>
          <p class="mb-0"><?php echo htmlspecialchars($description); ?></p>
        </div>
      </div>
      <p>
        <strong>Date & Time:</strong> <?php echo formatTimestamp($current['dt']); ?><br>
        <strong>Humidity:</strong> <?php echo htmlspecialchars($current['humidity']); ?>%<br>
        <strong>Pressure:</strong> <?php echo htmlspecialchars($current['pressure']); ?> hPa<br>
        <strong>Wind:</strong> <?php echo htmlspecialchars($current['wind_speed']); ?> m/s, <?php echo htmlspecialchars($current['wind_deg']); ?>°<br>
        <strong>Cloudiness:</strong> <?php echo htmlspecialchars($current['clouds']); ?>%<br>
        <strong>Visibility:</strong> <?php echo htmlspecialchars($current['visibility'] / 1000); ?> km<br>
        <strong>Sunrise:</strong> <?php echo formatTimestamp($current['sunrise'], "H:i"); ?> &nbsp; 
        <strong>Sunset:</strong> <?php echo formatTimestamp($current['sunset'], "H:i"); ?>
      </p>
    </section>

    <!-- 7-Day Forecast Section -->
    <section>
      <h2 class="mb-4 text-center">7-Day Forecast</h2>
      <div class="row">
        <?php
        // Loop through daily forecast data (limit to 7 days)
        foreach ($data['daily'] as $index => $day):
          if ($index >= 7) break;
          $dayData = $day;
          $dayIcon = $dayData['weather'][0]['icon'];
          $dayDesc = ucwords($dayData['weather'][0]['description']);
          ?>
          <div class="col-md-4">
            <div class="forecast-day text-center mb-4">
              <h5><?php echo formatTimestamp($dayData['dt'], "D, d M"); ?></h5>
              <img class="weather-icon" src="http://openweathermap.org/img/wn/<?php echo htmlspecialchars($dayIcon); ?>@2x.png" alt="Icon">
              <p class="mb-1"><strong><?php echo htmlspecialchars($dayDesc); ?></strong></p>
              <p class="mb-1">
                <span>Min: <?php echo htmlspecialchars(round($dayData['temp']['min'])); ?> °C</span><br>
                <span>Max: <?php echo htmlspecialchars(round($dayData['temp']['max'])); ?> °C</span>
              </p>
              <p class="mb-1">
                <small>Clouds: <?php echo htmlspecialchars($dayData['clouds']); ?>%</small>
              </p>
              <p class="mb-1">
                <small>Wind: <?php echo htmlspecialchars($dayData['wind_speed']); ?> m/s</small>
              </p>
              <p class="mb-1">
                <small>Humidity: <?php echo htmlspecialchars($dayData['humidity']); ?>%</small>
              </p>
              <p class="mb-0">
                <small>Precipitation: <?php echo isset($dayData['pop']) ? htmlspecialchars(round($dayData['pop'] * 100)) . '%' : 'N/A'; ?></small>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>

  <!-- Bootstrap JS (optional, for interactive components) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
