<?php
// PHP code for milestone logic
// Function to fetch milestone checklist based on child's age
function getMilestoneChecklist($child_age) {
    $milestones = [];

    // Define milestones for different age ranges (in months)
    $milestones[] = [
        'age_range' => '0-3 months',
        'milestones' => [
            'Smiles responsively',
            'Follows objects with eyes',
            'Attempts to lift head briefly when on tummy',
            // Add more milestones for this age range
        ]
    ];

    $milestones[] = [
        'age_range' => '4-6 months',
        'milestones' => [
            'Rolls over in both directions',
            'Babbles consonant sounds',
            'Reaches for and grabs objects',
            // Add more milestones for this age range
        ]
    ];

    // Add more age ranges and milestones as needed...

    // Find the appropriate age range for the child and return its milestones
    foreach ($milestones as $milestone) {
        if (strpos($milestone['age_range'], '-') !== false) {
            list($min_age, $max_age) = explode('-', $milestone['age_range']);
            if ($child_age >= $min_age && $child_age <= $max_age) {
                return $milestone['milestones'];
            }
        }
    }

    // If no matching age range is found, return an empty array
    return [];
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["child_age"])) {
    $child_age = $_GET["child_age"];
    $milestone_checklist = getMilestoneChecklist($child_age);
    header('Content-Type: application/json');
    echo json_encode($milestone_checklist);
    exit;
}
?>
