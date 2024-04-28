<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dob"])) {
    // Get child's date of birth from the form
    $dob = $_POST["dob"];

    // Calculate vaccination schedule based on the child's date of birth
    $schedule = calculateVaccinationSchedule($dob);

    // Display vaccination reminders
    if (!empty($schedule)) {
        echo "<h2>Vaccination Schedule:</h2>";
        echo "<ul>";
        foreach ($schedule as $vaccination) {
            echo "<li>$vaccination</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No vaccination schedule found for the given date of birth.</p>";
    }
}

// Function to calculate vaccination schedule based on the child's date of birth
function calculateVaccinationSchedule($dob) {
    // Sample vaccination schedule
    $vaccination_schedule = [
        '2 months: First Dose of DTP-HepB-Hib (Diphtheria, Tetanus, Pertussis, Hepatitis B, Haemophilus influenzae type b)',
        '2 months: First Dose of IPV (Inactivated Poliovirus)',
        '2 months: First Dose of PCV (Pneumococcal Conjugate)',
        '2 months: First Dose of Rotavirus Vaccine',
        // Add more vaccinations for different ages
    ];

    // Sample logic to calculate age in months
    $today = new DateTime();
    $birthdate = new DateTime($dob);
    $interval = $today->diff($birthdate);
    $age_months = $interval->y * 12 + $interval->m;

    // Filter vaccinations based on age
    $schedule = [];
    foreach ($vaccination_schedule as $vaccination) {
        preg_match('/(\d+) months:/', $vaccination, $matches);
        if ($matches && isset($matches[1]) && intval($matches[1]) <= $age_months) {
            $schedule[] = $vaccination;
        }
    }

    return $schedule;
}
?>
