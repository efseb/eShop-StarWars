<?php namespace Controllers;

use Cart\Cart;
use Cart\SessionStorage;
use Models\History;
use Models\Customer;
use Models\Product;
use Models\Image;
use Models\Tag;

class FrontController
{
    private $cart;
    public function __construct()
    {
        $this->cart = new Cart(new SessionStorage('starwars'));
    }
    public function index()
    {
        $product = new Product;
        $products = $product->all();
        //var_dump($products);

        $image = new Image;
        $tag = new Tag;

        view('front.index', compact('products', 'image', 'tag'));
    }

    public function show($id)
    {
        $productModel = new Product;

        $product = $productModel->find($id);

        $tag = new Tag();
        $image = new Image;

        view('front.single', compact('product', 'tag', 'image'));
    }

    public function showCart()
    {
        var_dump($_SESSION);

        $storage = $this->cart->all();
        foreach($storage as $id => $total)
        {
            $p = new Product;
            $stmt = $p->find($id);

            $products[$stmt->title]['price'] = (float) $stmt->price;
            $products[$stmt->title]['total'] = $total;
            $products[$stmt->title]['quantity'] = $total/$stmt->price; // todo price = 0 ;
            $products[$stmt->title]['product_id'] = $id;
        }
        $image = new Image;

        view('front.cart', compact('products', 'tag', 'image'));
    }

    public function command()
    {
        //var_dump($_POST);
        $rules = [
            'price' => FILTER_VALIDATE_FLOAT,
            'name' => FILTER_VALIDATE_INT,
            'quantity' => FILTER_VALIDATE_INT
        ];
        $sanitize = filter_input_array(INPUT_POST, $rules);
        var_dump($sanitize);

        $productCart = new \Cart\Product($sanitize['name'],$sanitize['price']);
        var_dump($productCart);

        $this->cart->buy($productCart, $sanitize['quantity']);

        $this->redirect(url());
    }

    public function store()
    {

        if(!checked_token($_POST['_token']))
        {
            $this->redirect(url('cart'));
        }
        if(empty($_SESSION)) session_start();
        if(!empty($_SESSION['old'])) $_SESSION['old']=[];
        if(!empty($_SESSION['error'])) $_SESSION['error']=[];

        $rules = [
           'email' => FILTER_VALIDATE_EMAIL,
           'number' => [
                    'filter' => FILTER_CALLBACK,
                    'options' => function($nb)
                    {
                        if(preg_match('/[0-9]{16}/', $nb)) return (int) $nb;
                        return false;
                    }
           ],
           'address' => FILTER_SANITIZE_STRING
        ];

        $sanitize = filter_input_array(INPUT_POST, $rules);
        var_dump($sanitize);

        $error = false;
        if(!$sanitize['email'])
        {
            $error = true;
            $_SESSION['error']['email'] = ' Your email is invalid';
        }
        if(!$sanitize['number']);
        {
            $error = true;
            $_SESSION['error']['number'] = ' Your blue card number is invalid';
        }
        if(empty($sanitize['address']));
        {
            $error = true;
            $_SESSION['error']['address'] = ' You must give your address';
        }
        if($error)
        {
            $_SESSION['old']['email'] = $sanitize['email'];
            $_SESSION['old']['address'] = $sanitize['address'];
            $this->redirect(url('cart'));
        }

        try{
            \Connect::$pdo->beginTransaction();

            $history = new History();
            $customer = new Customer();

            $customer->create(['email' => $sanitize['email'], 'number' => $sanitize['number'],
                'address' => $sanitize['address']]);

            $customerId = \Connect::$pdo->lastInsertId();

            $storage = $this->cart->all();
            foreach($storage as $id => $total)
            {
                $p = new Product;
                $stmt = $p->find($id);

                $history->create([
                    'product_id' =>$id,
                    'customer_id' => $customerId,
                    'price' => (float) $stmt->price,
                    'total' => $total,
                    'quantity' => $total/$stmt->price,
                    'commanded_at' => date('Y-m-d h:i:s')
                ]);
            }

            \Connect::$pdo->commit();

            $this->cart->reset();

        }catch(\PDOException $e)
        {
            \Connect::$pdo->rollback();
        }
    }

    private function redirect($path, $status='200 0k')
    {
        header("HTTP/1.1 $status");
        header('Content-Type: html/text charset=UTF-8');
        header("Location: $path");
        exit;
    }
}