<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class testLogin extends TestCase{

    private $conn;

    public function setUp(): void{
        $this->conn = new mysqli('localhost','root','','exemplebtc');
        if($this->conn->connect_error){
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function testNotEmptyInput(){
        session_start();
        $_POST['username'] = '';
        $_POST['password'] = '';
        $_POST['submit'] = 'Login';
    
        ob_start();
        require 'login.php';
        $output = ob_get_clean();
    
        $this->assertStringContainsString('Invalid username or password', $output);
    }

    public function testCorrectInput(){
        session_start();
        $hashed_password = password_hash('12345', PASSWORD_DEFAULT);
        
        $_POST['username'] = 'ProfDeMath';
        $_POST['password'] = $hashed_password;
        $_POST['submit'] = 'Login';

        require 'login.php';
        
        $this->assertEquals('ProfDeMath', $_SESSION['username']);
        $this->assertTrue(password_verify('12345', $_SESSION['password']));
    }

    public function testDatabaseConnection()
    {
        $this->assertNotNull($this->conn);
    }

    public function tearDown(): void
    {
        $this->conn->close();
    }
}
?>