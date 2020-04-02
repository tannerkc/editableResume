<?php
    include("includes/config.php");

    if(!isset($_SESSION['userLoggedIn'])){
        header("location: login.php");
    }
    $id = $_SESSION['id'];


    $query = mysqli_query($con, "SELECT * FROM resumeinfo WHERE userID = '$id'");

    while($row = mysqli_fetch_array($query)) {
			
        $name = $row['name'];
        $title = $row['title'];
        $email = $row['email'];
        $phone = $row['phone'];
        $street = $row['street'];
        $address = $row['address'];
        $skills = $row['skills'];
        $languages = $row['languages'];
        $platforms = $row['platforms'];
        $summary = $row['summary'];

        $file = explode(" ", $name);
        $file = $file[0] ."_". $file[1];

    }

    $certs = mysqli_query($con, "SELECT * FROM certificates WHERE userID = '$id'");
    $exp = mysqli_query($con, "SELECT * FROM experience WHERE userID = '$id'");
    $edu = mysqli_query($con, "SELECT * FROM education WHERE userID = '$id'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="includes/style.css">

    <title><?php echo $name; ?>'s Resume</title>
</head>
<body>
    <div class="container" id="resume">
        <input class="input" type="text" name="name" id="name" value="<?php echo $name; ?>">
        <input class="input" type="text" name="title" id="title" value="<?php echo $title; ?>">

        <div class="contact">
            <input class="input" type="text" name="phone" id="phone" value="<?php echo $phone; ?>">
            <input class="input" type="email" name="email" id="email" value="<?php echo $email; ?>">
            <input class="input" type="text" name="address" id="address" value="<?php echo $address; ?>">
        </div>

        <hr>

        <div class="summary">
            <h2>Summary</h2>
            <textarea rows="4" class="input" type="text" name="summary" id="summary" placeholder="<?php echo $summary; ?>"></textarea>
        </div>

        <div class="education">
            <h2>Education</h2>
            <?php
                while($eduRow = mysqli_fetch_array($edu)) {
                    ?>
                    <div style="margin-bottom:12px;">
                    <input data-id="<?php echo $eduRow['id']; ?>" class="edu" type="text" name="school" id="school" value="<?php echo $eduRow['school']; ?>">
                    <input data-id="<?php echo $eduRow['id']; ?>" class="edu" type="text" name="gradYear" id="gradYear" value="<?php echo $eduRow['gradYear']; ?>">
                    <input data-id="<?php echo $eduRow['id']; ?>" class="edu" type="text" name="degree" id="degree" value="<?php echo $eduRow['degree']; ?>">
                    </div>
                <?php
                }
                ?>
        </div>

        <div class="experience">
            <h2>Experience</h2>
            <?php
                while($expRow = mysqli_fetch_array($exp)) {
                    ?>
                    <div style="margin-bottom:12px;">

                        <input data-id="<?php echo $expRow['id']; ?>" class="exp" type="text" name="title" id="title" value="<?php echo $expRow['title']; ?>">

                        <input data-id="<?php echo $expRow['id']; ?>" class="exp" type="text" name="company" id="company" value="<?php echo $expRow['company']; ?>">

                        <input data-id="<?php echo $expRow['id']; ?>" class="exp" type="text" name="duration" id="duration" value="<?php echo $expRow['duration']; ?>">

                        <textarea rows="6" data-id="<?php echo $expRow['id']; ?>" class="exp" type="text" name="description" id="description" placeholder="<?php echo $expRow['description']; ?>"></textarea>

                    </div>
                <?php
                }
                ?>
        </div>

        <div class="credentials">
            <div class="skills">
                <h2>Skills</h2>
                <h3>Languages: </h3>
                <!-- <input class="input" type="text" name="languages" id="languages" > -->
                <textarea class="input" type="text" name="languages" id="languages" placeholder="<?php echo $languages; ?>"></textarea><br>

                <h3>Other: </h3>
                <!-- <input class="input" type="text" name="platforms" id="platforms" > -->
                <textarea class="input" type="text" name="platforms" id="platforms" placeholder="<?php echo $platforms; ?>"></textarea><br>

            </div>

            <div class="certificates">
                <h2>Certificates & Awards</h2>
                <?php
                while($certRow = mysqli_fetch_array($certs)) {
                    ?>
                    <input data-id="<?php echo $certRow['id']; ?>" class="cert" type="text" name="title" id="title" value="<?php echo $certRow['title']; ?>">
                    <input data-id="<?php echo $certRow['id']; ?>" class="cert" type="text" name="provider" id="provider" value="<?php echo $certRow['provider']; ?>">
                    <input data-id="<?php echo $certRow['id']; ?>" class="cert" type="text" name="link" id="link" value="<?php echo $certRow['link']; ?>">
                <?php
                }
                ?>
                
            </div>
        </div>

    </div>

    <button class="pdfButton" onclick="generatePDF()">Download as PDF</button>

    <script
	  src="https://code.jquery.com/jquery-3.4.1.js"
	  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
      crossorigin="anonymous"></script>

    <script src="html2pdf.min.js"></script>

    <script>
      function generatePDF() {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById("resume");
        // Choose the element and save the PDF for our user.
        html2pdf()
          .from(element)
          .save('<?php echo $file; ?>.pdf');
      }
    </script>
      
    <script>

    document.querySelectorAll(".input").forEach(item => {
        item.addEventListener('keyup',function(e){

        let input = this.value;
        let tag = this.id
        console.log(input);
        console.log(tag);

        $.post("includes/handlers/ajax/updateInfo.php", { input: input, id: tag }).done(function(error){
            
            if(error != ""){
                alert(error);
                return;
            }
        });

        });
    });

    document.querySelectorAll(".cert").forEach(item => {
        item.addEventListener('keyup',function(e){

        let input = this.value;
        let tag = this.id
        let id = this.dataset.id;
        console.log(input);
        console.log(tag);
        console.log(id);

        $.post("includes/handlers/ajax/updateCert.php", { input: input, id: id, tag: tag }).done(function(error){
            
            if(error != ""){
                alert(error);
                return;
            }
        });

        });
    });

    document.querySelectorAll(".edu").forEach(item => {
        item.addEventListener('keyup',function(e){

        let input = this.value;
        let tag = this.id
        let id = this.dataset.id;
        console.log("User Input: " + input);
        console.log("Field ID: " + tag);
        console.log("DB ID: " + id);

        $.post("includes/handlers/ajax/updateEdu.php", { input: input, id: id, tag: tag }).done(function(error){
            
            if(error != ""){
                alert(error);
                return;
            }
        });

        });
    });

    document.querySelectorAll(".exp").forEach(item => {
        item.addEventListener('keyup',function(e){

        let input = this.value;
        let tag = this.id
        let id = this.dataset.id;
        console.log("User Input: " + input);
        console.log("Field ID: " + tag);
        console.log("DB ID: " + id);

        $.post("includes/handlers/ajax/updateExp.php", { input: input, id: id, tag: tag }).done(function(error){
            
            if(error != ""){
                alert(error);
                return;
            }
        });

        });
    });

    </script>
</body>
</html>