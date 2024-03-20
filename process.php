<?php

function Cipher($ch, $key)
{
	if (!ctype_alpha($ch))
		return $ch;

	$offset = ord(ctype_upper($ch) ? 'A' : 'a');
	return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
}

function Encipher($input, $key)
{
	$output = "";

	$inputArr = str_split($input);
	foreach ($inputArr as $ch)
		$output .= Cipher($ch, $key);

	return $output;
}

function Cipher1($input, $oldAlphabet, $newAlphabet, &$output)
{
	$output = "";
	$inputLen = strlen($input);

	if (strlen($oldAlphabet) != strlen($newAlphabet))
		return false;

	for ($i = 0; $i < $inputLen; ++$i)
	{
		$oldCharIndex = strpos($oldAlphabet, strtolower($input[$i]));

		if ($oldCharIndex !== false)
			$output .= ctype_upper($input[$i]) ? strtoupper($newAlphabet[$oldCharIndex]) : $newAlphabet[$oldCharIndex];
		else
			$output .= $input[$i];
	}

	return true;
}

function Encipher1($input, $cipherAlphabet, &$output)
{
    // Initialize the $output variable
    $output = "";
	$plainAlphabet = "abcdefghijklmnopqrstuvwxyz";
	return Cipher1($input, $plainAlphabet, $cipherAlphabet, $output);
}

if (isset($_POST["register"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "Username: $username<br>";
    echo "Password before encryption (Caesar Cipher function):  $password<br>";

    // Encrypting the password using Caesar cipher with key 3
    $encrypted_password = Encipher($password, 3);
    echo "Password after encryption (Caesar Cipher function): $encrypted_password<br>";

    // Simple Substitution Caesar
    $cipherAlphabet = "zyxwvutsrqponmlkjihgfedcba"; 

    // Initializing $encrypted_password_substitution
    $encrypted_password_substitution = ''; 

    // Pass $encrypted_password_substitution by reference
    Encipher1($password, $cipherAlphabet, $encrypted_password_substitution); 
    echo "Password after encryption (Simple Substitution Cipher function): $encrypted_password_substitution<br>";

    // Hashing the password using password_hash() function
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Outputting hashed password
    echo "Hashed Password: $hashed_password";

} else {
    echo "Try again";
}
