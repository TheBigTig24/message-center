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
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700&family=Schoolbell&display=swap" rel="stylesheet">
    <script src="../scripts/home.js"></script>
    <script src="https://kit.fontawesome.com/8284d2aa07.js" crossorigin="anonymous"></script>
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
            $exampleMessage = new Message("Top Secret Message", 
            "I love Hanni so much, she is the best!", 
            "TheBigTig", 
            "Caleb", 
            date("Y-m-d H:i:s")
            );

            $messages = array($exampleMessage);
            foreach($messages as $message): ?>
                <div class="message-div">
                    <h1 class="schoolbell-regular" id="message-subject"><?php echo $message->getSubject(); ?></h1>
                    <h1 class="schoolbell-regular" id="message-receiver">From: <?php echo $message->getSender(); ?></h1>
                </div>
        <?php endforeach; ?>
    </div>

    <?php 
    
    ?>

    <!-- add to list section -->
    <div id="add-to-list">
        <div id="add-to-list-header">
            <h1 id="add-to-list-title" class="schoolbell-regular" >Send Message</h1>
            <i class="fas fa-chevron-down" style="font-size: 24px;"></i>
        </div>

        <form id="add-to-list-form" style="display: none;" action="index.php" method="post">
            <div class="input-container">
                <label for="form-receiver" class="schoolbell-regular">To: </label>
                <input type="text" id="form-receiver" required>
            </div>
            <div class="input-container">
                <label for="form-subject" class="schoolbell-regular">Subject: </label>
                <input type="text" id="form-subject" required>
            </div>
            <div class="input-container" style="flex-grow: 1;">
                <label for="form-body" class="schoolbell-regular"></label>
                <textarea id="form-body" placeholder="Type your message here..." required></textarea>
            </div>
            <input type="submit" id="form-submit" class="schoolbell-regular" value="Send"></input>
        </form>
    </div>

</body>
</html>