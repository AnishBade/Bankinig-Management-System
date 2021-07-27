<?php
session_start();
require_once 'pdo.php';

if(isset($_POST['logout'])){
    header('Location:logout.php');
    return;
}elseif(isset($_POST['delete'])){
    $sql="delete from customer where customer_id=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(array(
        ':id'=>$_POST['customer_id']
    ));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
</head>

<body>
    <h1><?php echo $_SESSION['name']; ?></h1> 
    <table border='2'>
        <tr>
            <th>customer_id</th>
            <th>Name</th>
            <th>Address</th>
            <th>branch_id</th>
            <th>account_balance</th>
            <th>action</th>
        </tr>
            <?php
                $sql='select customer_id,customer_name,customer_address,branch_id,account_balance from customer where branch_id=:branch_id ';
                $stmt=$pdo->prepare($sql);
                $stmt->execute(array(
                    ':branch_id'=>$_SESSION['branch_id']
                ));
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr><td>";
                    echo($row['customer_id']);
                    echo "</td><td>";
                    echo($row['customer_name']);
                    echo "</td><td>";
                    echo($row['customer_address']);
                    echo "</td><td>";
                    echo($row['branch_id']);
                    echo "</td><td>";
                    echo($row['account_balance']);
                    echo "</td></tr>";
                    echo "</td><td>";
                    echo('<form method="post"><input type="hidden" ');
                    echo('name="customer_id" value="'.$row['customer_id'].'">'."\n");
                    echo('<input type="submit" value="Del" name="delete">');
                    echo "\n</form>\n"."</td></tr>";
                }
        
            ?>
    </table> 

    <p>
        <form action="" method="post">
            <input type="submit" value="Logout" name="logout">
        </form>
    </p>  
</body>
</html>