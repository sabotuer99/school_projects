<?php

echo "Selected Scope\n";
echo $_GET['ideascope']."\n";

echo "Selected Type\n";
echo $_GET['ideatype']."\n";

echo "Selected Gender\n";
echo $_GET['genderselect']."\n";

echo "Selected Moods\n";
foreach ($_GET['moodselect'] as $selectedOption)
    echo $selectedOption."\n";
    
echo "Selected Age Ranges\n";
foreach ($_GET['ageselect'] as $selectedOption)
    echo $selectedOption."\n";
    
?>