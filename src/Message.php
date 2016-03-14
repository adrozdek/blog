<?php

class Message
{

    static private $connection = null;

    static public function SetConnection(mysqli $connection)
    {
        Message::$connection = $connection;
    }

    private $id;
    private $sendId;
    private $receiveId;
    private $messageText;
    private $messageDate;

    public function __construct($id, $sendId, $receiveId, $messageText, $messageDate, $opened) {
        $this->id = intval($id);
        $this->sendId = $sendId;
        $this->receiveId = $receiveId;
        $this->messageDate = $messageDate;
        $this->messageText = $messageText;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMessageDate()
    {
        return $this->messageDate;
    }

    public function getMessageText()
    {
        return $this->messageText;
    }

    public function getReceiveId()
    {
        return $this->receiveId;
    }

    public function getSendId()
    {
        return $this->sendId;
    }





}