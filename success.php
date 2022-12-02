<?php require_once './elements/header.php'; ?>

<style>footer{margin-top: 0;}</style>
<div class="banner" style="display:flex;align-items:center;margin:0;justify-content:center;">
    <h1 class="success">Your message has been sent successfully!<br>You will be redirected to the Contacts page automatically.</h1>
</div>

<?php require_once './elements/footer.php';

// header('Refresh: 10; url="/"');

$to      = 'test@test.com';
$subject = 'Test catalog';
$name = $_POST['name'];
$email = $_POST['email'];
$cost = $_POST['sum'];

mail($to, $subject, $name, $email, $cost);

$n = count($_COOKIE);
for ($i = $n; $i > 0; $i--) { 
    if ($_COOKIE) {    
        $cook_val = array('id' => $_GET['id'], 'title' => $_GET['title'], 'price' => $_GET['price']);
            
        setcookie('product' . $i, serialize($cook_val),time()-1800);
    }else{
        break;
    }
}
