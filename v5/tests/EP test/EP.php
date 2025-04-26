<?php
function isValidPrice($price) {
    return ($price >= 1 && $price <= 1000);
}

function isValidQuantity($quantity) {
    return ($quantity >= 0);
}

function isValidCon($condition) {
    return !empty($condition);
}

function isValidCat($category) {
    return !empty($category);
}

function isValidUser($username, $password) {
    return ($username == "user1" && $password == "password123");
}
$testCases = [
    ['price' => 100, 'quantity' => 0, 'condition' => "New", 'category' => "Actio", 'username' => "user1", 'password' => "password123", 'test_case' => 1],
    ['price' => -5, 'quantity' => -1, 'condition' => "", 'category' => "", 'username' => "wrongUsername", 'password' => "Wrongpassword", 'test_case' => 2],
];
foreach ($testCases as $test) {
    echo "Test Case:" . $test['test_case'] . ":<br>";
    $priceTest = isValidPrice($test['price']) ? "PASS" : "FAIL";
    $quantityTest = isValidQuantity($test['quantity']) ? "PASS" : "FAIL";
    $conditionTest = isValidCon($test['condition']) ? "PASS" : "FAIL";
    $categoryTest = isValidCat($test['category']) ? "PASS" : "FAIL";
    $userTest = isValidUser($test['username'], $test['password']) ? "PASS" : "FAIL";

    echo "Price Test: " . $priceTest . "<br>";
    echo "Quantity Test: " . $quantityTest . "<br>";
    echo "Condition Test: " . $conditionTest . "<br>";
    echo "Category Test: " . $categoryTest . "<br>";
    echo "User Login Test: " . $userTest . "<br><br>";
}
?>
