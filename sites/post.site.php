
<?php /*
IDEEN FÜR POST
.) Comments müssen alle aufgelistet werden das bedeutet man muss eine include datei machen. (DOCH NICHT)
   Dann müss für jeden commentar aus der datenbank ein comment erstellt werden und hier eingefügt werden.
   Thats pretty hard.
   Lösungsvorschlag: mit sql query herausfinden, wie viele comments bei jedem Post und dann so viele Platzhalter erstellen, 
   die dann befüllt werden. (MIT FOR SCHLEIFE!!!)
   und in der for schleife, kann man dann die comments gleich ausfüllen, und zwar in jedem durchgang dann die comments
   gleich befüllen (herausfinden mit kombination aus comment_ID und post_ID)

*/
?>

<div>
<div class="row">

    <div class="col-md-3"> <?php //platzhalter mit back-button ?>


    </div>
    <div class="col-md-6"> <?php //Post mit comments lets gooooo hype it up man ?>


        <div class="row"> <?php //oben profil und menupunkte ?>
            
                <div class="col-md-3">
                    <?php //PROFILEPIC ?>
                    <img class="singlepostProfilepic" src="res/pics/tokyo-ghoul-re-1.jpg" />
                </div>
                <div class="col-md-8 singlepostUsername">
                    <?php //USERNAME (evtl clickable um zum jeweiligen Profil zu gelangen) ?>
                    trylikeabun
                </div>
                <div class="col-md-1">
                <?php //MENUBUTTON für löschen etc LINKS ANORDNEN ?>
                <img class="singlepostDelete" src="res/icons/delete.png" alt="delete post">
                </div>
            
            
        </div>
        <div>

            <p class="singlepostText">
                Das ist der text zu meinem post hallo meine Freunde was geht hahahah omg cooles bild oder?
            </p>

        </div>
        <div> <?php //BILD/GRAFIK/NUDES/WASWEISSICH ?>

            <img class="singlepostPic" src="res/pics/narutotest.jpeg" alt="loading... maybe try to refresh the page">

        </div>
        <div class="row"> <?php //COMMENTSECTION das wird zach lol ?>

            <div class="col-md-2">

            </div>
            <div class="col-md-10">

            </div>

        </div>

    </div>
    <div class="col-md-3"> <?php //platzhalter ?>


    </div>
</div>
</div>




<div class="feedPost">
<div class="row"> <!-- profilepic und username -->
    <div class="col-1 postProfilepicBorder">
        <img class="postProfilepic" src="res/pics/tokyo-ghoul-re-1.jpg" />
    </div>
    <div class="col-11 postUsername">
        <div>
            trylikeabun
        </div>
    </div>
</div>
<div> <!-- post mit text und bild -->
    <div>
        <p class="postText">
            lorem ipsum bla bla hallo mein name ist Tribun und willkommen in dieser beschissenen social media plattform fucking kms
        </p>
    </div>
    <div>
        <img class="postPicture" src="res/pics/narutotest.jpeg" alt="fuckin ballz">
    </div>
</div>
<div class="row postIcons"> <!-- likes und kommentare -->
    <div class="col-2">
        <div class="row">
            <div class="col postIcon">
                <img class="postIcon" src="res/icons/not_liked.png" alt="like">
            </div>
            <div class="col postIcon">
                <img class="postIcon" src="res/icons/not_disliked.png" alt="dislike">
            </div>
            <div class="col postIcon">
                <img class="postIcon" src="res/icons/comment.png" alt="comment">
            </div>
        </div>
    </div>
    <div class="col-10">

    </div>
</div>
</div>