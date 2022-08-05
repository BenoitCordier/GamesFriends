<?php
// Model Comment qui gérera tout ce qui se rapporte aux messages
class Message
{
    private $id;
    private $fromPlayerId;
    private $toPlayerId;
    private $content;
    private $date;

    // Constructeur

    public function __construct($fromPlayerId, $toPlayerId, $content, $date)
    {
        $this->_fromPlayerId = $fromPlayerId;
        $this->_toPlayerId = $toPlayerId;
        $this->_content = $content;
        $this->_date = $date;
    }

    // Getter

    public function id()
    {
        return $this->_id;
    }

    public function fromPlayerId()
    {
        return $this->_fromPlayerId;
    }

    public function toPlayerId()
    {
        return $this->_toPlayerId;
    }

    public function content()
    {
        return $this->_content;
    }

    public function date()
    {
        return $this->_date;
    }

    // Setter

    public function setId()
    {
        $this->_id = $id;
    }

    public function setFromPlayerId($fromPlayerId)
    {
        $this->_fromPlayerId = $fromPlayerId;
    }

    public function setToPlayerId($toPlayerId)
    {
        $this->_toPlayerId = $toPlayerId;
    }

    public function setContent($content)
    {
        $this->_content = $content;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    // Hydrate

    public function hydrate(array $data)
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }

        if (isset($data['fromPlayerId'])) {
            $this->setFromPlayerId($data['fromPlayerId']);
        }

        if (isset($data['toPlayerId'])) {
            $this->setToPlayerId($data['toPlayerId']);
        }

        if (isset($data['content'])) {
            $this->setContent($data['content']);
        }

        if (isset($data['date'])) {
            $this->setDate($data['date']);
        }
    }
}

class MessageManager
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
    // Récupération des messages associés à un user
    public function getUserMessage($fromPlayerId, $toPlayerId)
    {
        $sql = 'SELECT * DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin\') AS messageDateFr FROM message WHERE fromPlayerId = fromPlayerId AND toPlayerId = toPlayerId ORDER BY date DESC';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([$fromPlayerId]);
        $messages = new Message($stmt);

        return $messages;
    }
    // Envoi d'un nouveau message
    public function sendMessage($fromPlayerId, $toPlayerId, $content)
    {
        $sql = 'INSERT INTO message(fromPlayerId, toPlayerId, content, date) VALUES(?, ?, ?, NOW())';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([$fromPlayerId, $toPlayerId, $content]);
        $sendMessage = new Message($stmt);

        return $sendMessage;
    }
    // Suppression d'un message
    public function deleteMessage($id)
    {
        $sql = 'DELETE FROM message WHERE id = ?';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([$id]);
        $deletedMessage = $stmt;

        return $deletedMessage;
    }
}
