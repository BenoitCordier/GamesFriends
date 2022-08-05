<?php
// Model Player qui gérera tout ce qui se rapporte aux utilisateurs
class Player
{
    private $_id;
    private $_playerName;
    private $_password;
    private $_eMail;
    private $_playerLocation;
    private $_status;

    // Constructeur

    public function __construct($datas)
    {
        $this->hydrate($datas);
    }

    // Getters

    public function id()
    {
        return $this->_id;
    }

    public function playerName()
    {
        return $this->_playerName;
    }

    public function password()
    {
        return $this->_password;
    }

    public function eMail()
    {
        return $this->_eMail;
    }

    public function playerLocation()
    {
        return $this->_playerLocation;
    }
    
    public function status()
    {
        return $this->_status;
    }

    // Setters

    public function setId()
    {
        $this->_id = $id;
    }

    public function setUserName($playerName)
    {
        $this->_playerName = $playerName;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function setEmail($eMail)
    {
        $this->_eMail = $eMail;
    }

    public function setPlayerLocation($playerLocation)
    {
        $this->_playerLocation = $playerLocation;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    // Hydrate

    public function hydrate(array $data)
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }

        if (isset($data['playerName'])) {
            $this->setUserName($data['playerName']);
        }

        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }

        if (isset($data['eMail'])) {
            $this->setEmail($data['eMail']);
        }

        if (isset($data['playerLocation'])) {
            $this->setPlayerLocation($data['playerLocation']);
        }

        if (isset($data['status'])) {
            $this->setStatus($data['status']);
        }
    }
}

class PlayerManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb($db)
    {
        $this->_db = $db;
    }

    // Method
    // Enregistrement d'un nouvel utilisateur
    public function signIn($playerName, $passHash, $eMail, $playerLocation, $games)
    {
        $sql = "INSERT INTO player(playerName, eMail, password, playerLocation, games, status) VALUES(:playerName, :eMail, :passHash, :playerLocation, :games, 'player')";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':playerName', $playerName);
        $stmt->bindParam(':passHash', $passHash);
        $stmt->bindParam(':eMail', $eMail);
        $stmt->bindParam(':playerLocation', $playerLocation);
        $stmt->bindParam(':games', $games);
        $result = $stmt->execute();
        $player = new Player($result);

        return $player;
    }
    // Récupération des informations d'un utilisateur
    public function getPlayerInfo($playerName)
    {
        $sql = "SELECT * FROM player WHERE playerName = ?";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([$playerName]);
        $result = $stmt->fetch();
        $player = new Player($result);

        return $player;
    }
    // Modification de mot de passe
    public function modifyPassword($id, $newPassHash)
    {
        $sql = 'UPDATE player SET password = :newPassHash WHERE id = :id';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(["id" => $id, "password" => $newPassHash]);
        $updatedPassword = $stmt;

        return $updatedPassword;
    }
    // Modification de localisation
    public function modifyPlayerLocation($id, $newPlayerLocation)
    {
        $sql = 'UPDATE player SET playerLocation = :newPlayerLocation WHERE id = :id';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(["id" => $id, "playerLocation" => $newPlayerLocation]);
        $updatedLocation = $stmt;

        return $updatedLocation;
    }
    // Modifiction des jeux
    public function modifyGames($id, $newGames)
    {
        $sql = 'UPDATE player SET games = :games WHERE id = :id';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(["id" => $id, "games" => $newGames ]);
        $updatedGames = $stmt;

        return $updatedGames;
    }
    // Modification du type d'utilisateur
    public function selectStatus($id, $newStatus)
    {
        $sql = 'UPDATE player SET status = :newStatus WHERE id = :id';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(["id" => $id, "status" => $newStatus]);
        $updatesStatus = $stmt;

        return $updatesStatus;
    }
    // Suppression d'un utilisateur
    public function deletePlayer($id)
    {
        $sql = 'DELETE FROM player WHERE id = ?';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([$id]);
        $deletedPlayer = $stmt;

        return $deletedPlayer;
    }
}
