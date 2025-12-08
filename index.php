<?php

namespace App\Models;

use \PDO;

class SqlConnect {
  public object $db;
  private string $host;
  private string $port;
  private string $dbname;
  private string $password;
  private string $user;

  public function __construct() {
    $this->host = '127.0.0.1';
    $this->port = '3306';
    $this->dbname = 'demo';
    $this->user = 'root';
    $this->password = 'root';

    $this->db = new PDO(
      'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,
      $this->user,
      $this->password
    );

    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->db->setAttribute(PDO::ATTR_PERSISTENT, false);
  }

  public function transformDataInDot($data) {
    $dataFormated = [];

    foreach ($data as $key => $value) {
      $dataFormated[':' . $key] = $value;
    }

    return $dataFormated;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataille</title>
</head>

<body>
    <main>
        <table>
            <caption>
                J1
            </caption>
            <tr>
                <th></th>
                <th scope="col">1</th>
                <th scope="col">2</th>
                <th scope="col">3</th>
                <th scope="col">4</th>
                <th scope="col">5</th>
                <th scope="col">6</th>
                <th scope="col">7</th>
                <th scope="col">8</th>
                <th scope="col">9</th>
                <th scope="col">10</th>
            </tr>
            <tr>
                <th scope="row">A</th>
                <td><button name="A1" method="post">A1</button></td>
                <td><button name="A2" method="post">A2</button></td>
                <td><button name="A3" method="post">A3</button></td>
                <td><button name="A4" method="post">A4</button></td>
                <td><button name="A5" method="post">A5</button></td>
                <td><button name="A6" method="post">A6</button></td>
                <td><button name="A7" method="post">A7</button></td>
                <td><button name="A8" method="post">A8</button></td>
                <td><button name="A9" method="post">A9</button></td>
                <td><button name="A10" method="post">A10</button></td>
            </tr>
            <tr>
                <th scope="row">B</th>
                <td><button name="B1" method="post">B1</button></td>
                <td><button name="B2" method="post">B2</button></td>
                <td><button name="B3" method="post">B3</button></td>
                <td><button name="B4" method="post">B4</button></td>
                <td><button name="B5" method="post">B5</button></td>
                <td><button name="B6" method="post">B6</button></td>
                <td><button name="B7" method="post">B7</button></td>
                <td><button name="B8" method="post">B8</button></td>
                <td><button name="B9" method="post">B9</button></td>
                <td><button name="B10" method="post">B10</button></td>
            </tr>
            <tr>
                <th scope="row">C</th>
                <td><button name="" method="post">C1</button></td>
                <td><button name="" method="post">C2</button></td>
                <td><button name="" method="post">C3</button></td>
                <td><button name="" method="post">C4</button></td>
                <td><button name="" method="post">C5</button></td>
                <td><button name="" method="post">C6</button></td>
                <td><button name="" method="post">C7</button></td>
                <td><button name="" method="post">C8</button></td>
                <td><button name="" method="post">C9</button></td>
                <td><button name="" method="post">C10</button></td>
            </tr>
            <tr>
                <th scope="row">D</th>
                <td><button name="" method="post">D1</button></td>
                <td><button name="" method="post">D2</button></td>
                <td><button name="" method="post">D3</button></td>
                <td><button name="" method="post">D4</button></td>
                <td><button name="" method="post">D5</button></td>
                <td><button name="" method="post">D6</button></td>
                <td><button name="" method="post">D7</button></td>
                <td><button name="" method="post">D8</button></td>
                <td><button name="" method="post">D9</button></td>
                <td><button name="" method="post">D10</button></td>
            </tr>
            <tr>
                <th scope="row">E</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row">F</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!--Je fais jusqu'à F -->
            <tr>
                <th scope="row">G</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row">H</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row">I</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row">J</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </main>
</body>

</html>