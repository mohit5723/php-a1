<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developmental Milestone Tracker</title>
    <style>
        /* CSS styling for the milestone tracker UI */
        /* You can move this to an external CSS file if preferred */
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="number"] {
            width: 100px;
            margin-bottom: 10px;
        }
        button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #milestoneChecklist {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Developmental Milestone Tracker</h1>
    <label for="childAge">Enter Child's Age (in months):</label>
    <input type="number" id="childAge" min="0" max="36">
    <button onclick="getMilestoneChecklist()">Get Milestone Checklist</button>
    <div id="milestoneChecklist"></div>

    <h1>Vaccination Reminder</h1>
    <form action="" method="post">
        <label for="dob">Child's Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
        <button type="submit" name="calculate">Calculate Vaccination Schedule</button>
    </form>

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

    <script>
        function getMilestoneChecklist() {
            var childAge = document.getElementById("childAge").value;
            if (childAge !== "") {
                // AJAX request to fetch milestone checklist based on child's age
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        try {
                            var milestoneChecklist = JSON.parse(this.responseText);
                            displayMilestoneChecklist(milestoneChecklist);
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                        }
                    }
                };
                xhr.open("GET", "get_milestone_checklist.php?child_age=" + childAge, true);
                xhr.send();
            } else {
                alert("Please enter child's age.");
            }
        }

        function displayMilestoneChecklist(milestoneChecklist) {
            var milestoneChecklistDiv = document.getElementById("milestoneChecklist");
            milestoneChecklistDiv.innerHTML = ""; // Clear previous checklist
            // Display milestone checklist
            milestoneChecklist.forEach(function(milestone) {
                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "milestone";
                checkbox.value = milestone;
                checkbox.disabled = true; // Disable checkboxes for demonstration
                var label = document.createElement("label");
                label.appendChild(document.createTextNode(milestone));
                var br = document.createElement("br");
                milestoneChecklistDiv.appendChild(checkbox);
                milestoneChecklistDiv.appendChild(label);
                milestoneChecklistDiv.appendChild(br);
            });
        }
    </script>
</body>
</html>
