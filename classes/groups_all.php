<?php


class Group
{
    protected $db;
    protected $groupName;
    protected $desc;
    protected $uname;
    protected $gname;

    function __construct($db_connection)
    {
        $this->db = $db_connection;
    }


    function createGroups($group_name, $description, $name, $username)
    {
        try {
            $this->groupName = trim($group_name);
            $this->desc = trim($description);
            $this->groupMembers = $name;

            //number of group member inputs
            $number = count($_POST["name"]);

            //all the members who go into groups
            $groups = [$username];
            for ($i = 0; $i < $number; $i++) {
                if (trim($_POST["name"][$i] != '')) {
                    //$sql = "INSERT INTO tbl_name(name) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
                    //mysqli_query($connect, $sql);
                    array_push($groups, $this->groupMembers[$i]);
                }
            }
            //converting array to string
            $groups_values = implode(",", $groups);

            if (!empty($this->groupName) && !empty($this->desc)) {
                $check_group = $this->db->prepare("SELECT * FROM groups WHERE group_name = ?");
                $check_group->execute([$this->groupName]);

                if ($check_group->rowCount() > 0) {
                    return ['errorMessage' => 'This group name already exists!! Try another one!'];
                } else {

                    $sql = "INSERT INTO groups (group_name,description,grp_members) VALUES (:grp_name,:description,:grp_members)";

                    $register_stmt = $this->db->prepare($sql);
                    $register_stmt->bindValue(':grp_name', $this->groupName, PDO::PARAM_STR);
                    $register_stmt->bindValue(':description', $this->desc, PDO::PARAM_STR);
                    $register_stmt->bindValue(':grp_members', $groups_values, PDO::PARAM_STR);

                    $register_stmt->execute();


                    return ['successMessage' => 'Group created successfully.'];
                }

            } else {
                return ['errorMessage' => 'Please fill group name and description.'];
            }
        } catch (PDOException $errorMsg) {
            die($errorMsg->getMessage());

        }
    }

    function allGroups($username)
    {
        try {
            $this->uname = trim($username);
            $sql_res = $this->db->prepare("SELECT id,group_name,grp_members FROM groups");
            $sql_res->execute();
            if($sql_res->rowCount() >0) {
                $all_rows = $sql_res->fetchAll(PDO::FETCH_OBJ);

                return $all_rows;
            }
            else{
                return false;
            }
        } catch (PDOException $errMsg) {
            die($errMsg->getMessage());
        }
    }

    function retrieveGroups($username, $bool_value)
    {
        try {
            $this->uname = trim($username);
            $sql_res = $this->db->prepare("SELECT id,group_name,grp_members FROM groups");
            $sql_res->execute();
            if($sql_res->rowCount() >0) {
                $all_rows = $sql_res->fetchAll(PDO::FETCH_OBJ);
                $groupNames = [];
                $groupIds = [];
                foreach ($all_rows as $row) {
                    $g_name = $row->group_name;
                    $g_id = $row->id;
                    $name_explode = explode(",", $row->grp_members);
                    foreach ($name_explode as $name_user) {
                        if ($this->uname === $name_user) {
                            array_push($groupNames,$g_name);
                            array_push($groupIds,$g_id);
                        }
                    }

                }
                if($bool_value){
                    return $groupNames;
                }
                else{
                    return $groupIds;
                }

            }
            else{
                return false;
            }
        } catch (PDOException $errMsg) {
            die($errMsg->getMessage());
        }
    }

    function find_group_members($groupName){
        try{
            $this->gname = trim($groupName);
            $get_users = $this->db->prepare("SELECT grp_members FROM groups WHERE group_name != ?");
            $get_users->execute([$groupName]);
            if($get_users->rowCount() >0){
                $get_all_users = $get_users->fetch(PDO::FETCH_OBJ);
                $all_group_users = [];
                foreach ($get_all_users as $row) {
                    $name_explode = explode(",", $row);
                    foreach ($name_explode as $name_user) {

                            array_push($all_group_users,$name_user);

                    }

                }
                return $all_group_users;
            }
            else{
                return false;
            }
        }
        catch (PDOException $errMsg) {
            die($errMsg->getMessage());
        }
    }
}