<?
  class Api
 {
 	private $host = 'https://jsonplaceholder.typicode.com/';

 	public function getUsers() {
        $url = $this->host . 'users';
        return $this->sendRequest('GET', $url);
    }

    public function getUserPosts($userId) {
        $url = $this->host . 'posts?userId=' . $userId;
        return $this->sendRequest('GET', $url);
    }

    public function getUserTodos($userId) {
        $url = $this->host . 'todos?userId=' . $userId;
        return $this->sendRequest('GET', $url);
    }


    public function getPost($postId)
    {
        $url = $this->host . 'posts/' . $postId;
        return $this->sendRequest('GET', $url);
    }

    public function addPost($postData)
    {
        $url = $this->host . 'posts';
        return $this->sendRequest('POST', $url, $postData);
    }

    public function updatePost($postId, $postData)
    {
        $url = $this->host . 'posts/' . $postId;
        return $this->sendRequest('PUT', $url, $postData);
    }

    public function deletePost($postId)
    {
        $url = $this->host . 'posts/' . $postId;
        return $this->sendRequest('DELETE', $url);
    }

    private function sendRequest($method, $url, $data = null)
	{
    	$options = [
        	'http' => [
            	'method' => $method,
            	'header' => 'Content-Type: application/json',
            	'content' => json_encode($data),
        	],
    	];

    	$context = stream_context_create($options);

    	try {
	        $result = file_get_contents($url, false, $context);
	        $response = json_decode($result, true);
	        return $response;
	    } catch (Exception $e) {
	        echo "Ошибка при обработке запроса на сервере: " . $e->getMessage();
	        return null;
	    }
	}
}


$api = new Api();

// Получение пользователей
$users = $api->getUsers();
var_dump($users);

// Получение постов пользователя
$userPosts = $api->getUserPosts(1);
var_dump($userPosts);

// Получение заданий пользователя
$userTodos = $api->getUserTodos(1);
var_dump($userTodos);

// Получение информации о посте
$post = $api->getPost(1);
var_dump($post);

//Добавление нового поста
$newPostData = [
	'userId' => 1,
    'id'=> 1001,
    'title' => 'New Post Title',
    'body' => 'New Post Body',   
];
$newPost = $api->addPost($newPostData);
var_dump($newPost);

//Редактирование поста
$updatedPostData = [
    'title' => 'Updated Post Title',
    'body' => 'Updated Post Body',
];
$updatedPost = $api->updatePost(1001, $updatedPostData);
var_dump($updatedPost);


// Удаление поста
$deleteResult = $api->deletePost(1001);
var_dump($deleteResult);

?>
