<?php
    class Message {
        private $subject;
        private $body;
        private $sender;
        private $receiver;
        private $date;

        public function __construct($subject = "", $body = "", $sender = "", $receiver = "", $date = "") {
            $this->subject = $subject;
            $this->body = $body;
            $this->sender = $sender;
            $this->receiver = $receiver;
            $this->date = $date;
        }

        public function getSubject() {
            return $this->subject;
        }

        public function getBody() {
            return $this->body;
        }

        public function getSender() {
            return $this->sender;
        }

        public function getReceiver() {
            return $this->receiver;
        }

        public function getDate() {
            return $this->date;
        }
    }
?>
<!DOCTYPE html>
<head>
    <title>Caleb Message Center</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700&family=Schoolbell&display=swap" rel="stylesheet">
    <script src="script.js"></script>
</head>
<body>
    <!-- header section -->
    <div id="header">
        <div id="logo-container">
            <img alt="Logo" id="logo">
        </div>
        <h1 id="title" class="outfit-bold">Messages</h1>
    </div>

    <!-- list section -->
    <div id="list-container">
        <?php 
            $exampleMessage = new Message("Hanni is the best!", 
            "I love Hanni so much, she is the best!", 
            "TheBigTig", 
            "Caleb", 
            date("Y-m-d H:i:s")
            );

            $messages = array($exampleMessage);
            foreach($messages as $message): ?>
                <div class="message-div">
                    <div class="message-header">
                        <h1 class="message-title outfit-bold"><?php echo $message->getSubject(); ?></h1>
                        <h2 class="message-sender outfit-bold"><?php echo $message->getSender(); ?></h2>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>

    <!-- add to list section -->
    <div id="add-to-list">
        <h1 id="add-to-list-title" class="schoolbell-regular" >Add to list</h1>
        <div id="plus-sign-container">
            <img src="../assets/plus.png" alt="plus-sign">
        </div>
        <form id="add-to-list-form" style="display: none;">
            <input type="text" id="form-title" placeholder="A title" required>
            <input type="text" id="form-message" placeholder="a description" required>
        </form>
    </div>

</body>
</html>