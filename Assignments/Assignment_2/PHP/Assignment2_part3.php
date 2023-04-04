<?php
//Write a PHP program that calculates and displays the average of numbers for only checked  checkboxes. Appropriate error message should be displayed if no checkbox is selected. In  addition, your program should list all checked checkboxes string values whose numbers  are above the average.
if ($_POST['num']) {
    $sum = 0;
    $count = 0;
    $number = $_POST['num'];
    foreach ($number as $num) {
        $list = explode('#', $num);
        $value = $list[0];
        $string = $list[1];
        $sum += $value;
        $count++;
    }
    $average = $sum / $count;
    echo "The average is $average <br />";
    foreach ($number as $num) {
        $list = explode('#', $num);
        $value = $list[0];
        $string = $list[1];
        if ($value > $average) {
            echo "The string value is above the average: $string <br />";
        }
    }
} else {
    echo "Please select at least one checkbox";
}
?>
<form method="post">
    <input type="checkbox" name="num[]" value="150#AAA" />AAA <br />
    <input type="checkbox" name="num[]" value="300#ZZZ" />ZZZ <br />
    <input type="checkbox" name="num[]" value="200#KKK" />KKK <br />
    <input type="checkbox" name="num[]" value="213#NNN" />NNN <br />
    <input type="submit" value="Calculate">
</form>