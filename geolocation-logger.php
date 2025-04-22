<?php
// Add this to the top of your geolocation-logger.php for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Improved Geolocation Logger
 * 
 * A secure and reliable implementation for logging visitor geolocation data
 */

/**
 * Get geolocation data for an IP address
 * @param string $ip The IP address to look up
 * @return array Geolocation data or error information
 */
// In your getGeolocation function, add this debugging line at the top:
function getGeolocation($ip) {
    // Debug output
    echo "Checking IP: " . $ip . "<br>";
    
    // Check if localhost/private IP and return dummy data for testing
    if ($ip == '127.0.0.1' || $ip == 'localhost' || preg_match('/^(10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.|192\.168\.)/', $ip)) {
        echo "Local IP detected, returning test data<br>";
        return [
            'status' => 'success',
            'query' => $ip,
            'country' => 'Test Country',
            'regionName' => 'Test Region',
            'city' => 'Test City',
            'lat' => '0.0',
            'lon' => '0.0'
        ];
    }
    
   
    // Use HTTPS for secure data transmission
    $url = "https://ip-api.com/json/{$ip}";
    
    // Set a timeout and use error handling
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    // Check if the request was successful
    if ($response === false) {
        return ['error' => 'Failed to fetch geolocation data'];
    }
    
    $data = json_decode($response, true);
    
    // Verify the response is valid
    if (json_last_error() !== JSON_ERROR_NONE || !isset($data['status']) || $data['status'] !== 'success') {
        return ['error' => 'Invalid geolocation data received'];
    }
    
    return $data;
}

/**
 * Get the actual client IP, even behind proxies
 * @return string The client's IP address or empty string if invalid
 */
function getClientIP() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '';
}

/**
 * Log the geolocation data to a file
 * @param array $geoData The geolocation data to log
 * @param string $logFile Path to the log file
 * @return bool True if logging was successful, false otherwise
 */
function logGeolocationData($geoData, $logFile = 'visitor_log.txt') {
    // Check if we have valid data
    if (isset($geoData['error'])) {
        error_log("Geolocation error: " . $geoData['error']);
        return false;
    }
    
    // Format the log entry
    $log_entry = date("Y-m-d H:i:s") . " - IP: " . ($geoData['query'] ?? 'unknown') . 
                 ", Country: " . ($geoData['country'] ?? 'unknown') . 
                 ", Region: " . ($geoData['regionName'] ?? 'unknown') . 
                 ", City: " . ($geoData['city'] ?? 'unknown') . 
                 ", Latitude: " . ($geoData['lat'] ?? 'unknown') . 
                 ", Longitude: " . ($geoData['lon'] ?? 'unknown') . "\n";

    // Create directory if it doesn't exist
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    // Debug file permissions
    if (!file_exists($logFile)) {
        error_log("Log file doesn't exist: $logFile");
        // Try to create it
        touch($logFile);
        chmod($logFile, 0666); // Make writable by everyone
    }
    
    if (!is_writable($logFile)) {
        error_log("Log file is not writable: $logFile");
        return false;
    }
    
    // Make sure we can write to the file
    $result = file_put_contents($logFile, $log_entry, FILE_APPEND | LOCK_EX);
    if ($result === false) {
        error_log("Failed to write to log file: $logFile");
        return false;
    }
    
    return true;
}

// Get and log visitor geolocation data
$ip = getClientIP();
$geoData = getGeolocation($ip);

echo "<pre>";
print_r($geoData);
echo "</pre>";

$logPath = "logs/visitor_log.txt";
if (!file_exists($logPath)) {
    echo "Log file does not exist. Attempting to create...<br>";
    $created = touch($logPath);
    echo $created ? "File created successfully.<br>" : "Failed to create file.<br>";
    chmod($logPath, 0666);
}

if (!is_writable($logPath)) {
    echo "Log file is not writable!<br>";
} else {
    echo "Log file is writable.<br>";
}

$result = logGeolocationData($geoData, $logPath);
echo "Log Result: " . ($result ? "Success" : "Failed") . "<br>";
?>
