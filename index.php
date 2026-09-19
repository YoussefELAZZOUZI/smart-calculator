<?php 

if (isset($_POST['number1']) && isset($_POST['number2'])){
    $number1Input = trim($_POST['number1']);
    $number2Input = trim($_POST['number2']);
    if ($number1Input === '' || $number2Input === '') {
        echo "Both numbers are required" . "<br>";
    } else {
        $number1 = (float) $number1Input;
        $number2 = (float) $number2Input;
        $operator = $_POST['operator'];
        $allowedOperators = ['+', '-', '*', '/', '%'];

        if (!in_array($operator, $allowedOperators, true)) {
            echo "Invalid operator";
        } else {
            if ($operator === "+"){
                echo $number1 + $number2;
            } elseif ($operator === "-"){
                echo $number1 - $number2;
            } elseif ($operator === "*"){
                echo $number1 * $number2;
            } elseif ($operator === "/"){
                if($number2 === 0.0){
                    echo "cannot divide by zero";
                } else {
                    echo $number1 / $number2;
                }
            } elseif ($operator === '%'){
                echo (int)$number1 % (int)$number2;
            }
        }
    }
}
?>

<form method="post">
    <input type="number" name="number1" step="any">
    <input type="number" name="number2" step="any">

    <select name="operator" >
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
        <option value="%">%</option>
    </select>
    <button type="submit">Calculate</button>
</form>