<?php

//class Advertisement {
abstract class Advertisement {

    public $id;
    public $manager;
    public $email;
    public $seller_name;
    public $phone;
    public $location_id;
    public $category_id;
    public $title;
    public $description;
    public $price;
    public $allow_mails = 0;

    function __construct($post_date) {
        if (isset($post_date["id"])) { // проверка наличия id в форме
            $this->id = $post_date["id"];
        }
        $this->manager = $post_date["manager"];
        $this->email = $post_date["email"];
        $this->seller_name = $post_date["seller_name"];
        $this->phone = $post_date["phone"];
        $this->location_id = $post_date["location_id"];
        $this->category_id = $post_date["category_id"];
        $this->title = $post_date["title"];
        $this->description = $post_date["description"];
        $this->price = $post_date["price"];
        $this->allow_mails = $post_date["allow_mails"];
    }

    public function sql_INSERT($bd, $adv) {
        $object_array = get_object_vars($adv);
        $bd->query('INSERT INTO form(?#) VALUES(?a)', array_keys($object_array), array_values($object_array));
    }

    static public function sql_DELETE($bd, $id_del) {
        $bd->select('DELETE FROM form WHERE id = ?', $id_del);
    }

    public function sql_UPDATE($bd, $adv) {
        $object_array = get_object_vars($adv);
        $id = $object_array["id"];
        $bd->query('UPDATE form SET ?a WHERE id =?', $object_array, $id);
    }

    public function getId() {
        return $this->id;
    }

    public function repository() {
        $repository = RepositoryAds::getinstance();
        $repository->addAdvertisement($this);
    }

    public function save($bd, $adv) {
        if (isset($this->id)) {
            $this->sql_UPDATE($bd, $adv);
        } else {
            $this->sql_INSERT($bd, $adv);
        }
    }

}


