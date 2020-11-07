<?php

//Api.php

class API
{
	private $connect = '';

	public function __construct()
	{
		$this->database_connection();
	}

    public function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=userapi", "root", "root");
	}

    public function list()
	{
		$query = "SELECT users.*, roles.name FROM users left join roles on users.role_id=roles.id ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	public function options()
	{
		$queryOptions = "SELECT * FROM roles";
		$options = $this->connect->prepare($queryOptions);
		$optionHtml = '';
		if($options->execute())
		{
			while($option = $options->fetch(PDO::FETCH_ASSOC))
			{
                $optionHtml .= '<option value="'.$option['id'].'">'.$option['name'].'</option>';
			}
            $data[]=$optionHtml;
			return $data;
		}
	}

    public function create()
	{

		if(isset($_POST["nick"]))
		{
			$form_data = array(
				':nick'		=>	$_POST["nick"],
				':password'		=>	$_POST["password"],
				':role_id'		=>	$_POST["role_id"],
				':additional_data'		=>	$_POST["additional_data"]
			);
			$query = "
			INSERT INTO users 
			(nick, password, role_id, additional_data) VALUES 
			(:nick, :password, :role_id, :additional_data)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

    public function get($id)
	{
		$query = "SELECT * FROM users WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['nick'] = $row['nick'];
				$data['password'] = $row['password'];
				$data['role_id'] = $row['role_id'];
				$data['additional_data'] = $row['additional_data'];
			}
			return $data;
		}
	}

    public function update()
	{
		if(isset($_POST["nick"]))
		{
			$form_data = array(
				':nick'	=>	$_POST['nick'],
				':password'	=>	$_POST['password'],
				':role_id'	=>	$_POST['role_id'],
				':additional_data'	=>	$_POST['additional_data'],
				':id'=>	$_POST['id']
			);
			$query = "
			UPDATE users 
			SET nick = :nick, password = :password , role_id = :role_id , additional_data = :additional_data 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			} else {
				$data[] = array(
					'success'	=>	'0'
				);
			}
		} else {
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM users WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>