<?php
session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Clear history
if (isset($_POST['clear_history'])) {
    $_SESSION['history'] = [];
}

// Calculator
if (isset($_POST['calculate'])){
    if (
        isset($_POST['number1']) &&
        isset($_POST['number2']) &&
        isset($_POST['operator'])
    ) {
        $number1Input = trim($_POST['number1']);
        $number2Input = trim($_POST['number2']);

        if ($number1Input === '' || $number2Input === '') {
            echo "Both numbers are required";
        } else {

            $number1 = (float) $number1Input;
            $number2 = (float) $number2Input;
            $operator = $_POST['operator'];

            $allowedOperators = ['+', '-', '*', '/', '%'];

            if (!in_array($operator, $allowedOperators, true)) {

                echo "Invalid operator";

            } else {

                if ($operator === "+") {

                    $result = $number1 + $number2;

                } elseif ($operator === "-") {

                    $result = $number1 - $number2;

                } elseif ($operator === "*") {

                    $result = $number1 * $number2;

                } elseif ($operator === "/") {

                    if ($number2 == 0) {
                        echo "Cannot divide by zero";
                        $result = null;
                    } else {
                        $result = $number1 / $number2;
                    }

                } elseif ($operator === "%") {

                    if ($number2 == 0) {
                        echo "Cannot modulo by zero";
                        $result = null;
                    } else {
                        $result = (int)$number1 % (int)$number2;
                    }
                }

                if ($result !== null) {

                    echo "<h2>Result: $result</h2>";

                    $calculation = "$number1 $operator $number2 = $result";

                    $_SESSION['history'][] = $calculation;
                }
            }
        }
    }
}
?>

<form method="post">

    <input type="number" name="number1" step="any">

    <input type="number" name="number2" step="any">

    <select name="operator">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
        <option value="%">%</option>
    </select>

    <button type="submit" name="calculate">Calculate</button>

    <button type="reset">Reset</button>

    <button type="submit" name="clear_history">
        Clear History
    </button>

</form>

<?php

if (!empty($_SESSION['history'])) {

    echo "<h2>History</h2>";

    echo "<ul>";

    foreach ($_SESSION['history'] as $calculation) {
        echo "<li>" . htmlspecialchars($calculation) . "</li>";
    }

    echo "</ul>";
}

?>