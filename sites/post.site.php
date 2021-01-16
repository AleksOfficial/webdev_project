
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
            
                <div class="col-md-1">
                    <?php //PROFILEPIC ?>
                    <img class="singlepostProfilepic" src="res/pics/tokyo-ghoul-re-1.jpg" />
                </div>
                <div class="col-md-9 singlepostUsername">
                    <?php //USERNAME (evtl clickable um zum jeweiligen Profil zu gelangen) ?>
                    trylikeabun -vor 3 Stunden
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-6">
                            <img class="singlepostDelete" src="res/icons/public_status.png" alt="delete post">
                        </div>
                        <div class="col-md-6">
                            <img class="singlepostDelete" src="res/icons/delete.png" alt="delete post">
                        </div>
                    </div>
                    <?php //MENUBUTTON für löschen etc LINKS ANORDNEN ?>
                    
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
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-4">
                        <img class="postReactions" src="res/icons/smile.png" alt="like">
                    </div>
                    <div class="col-md-4">
                        <img class="postReactions" src="res/icons/unbenanntes_Projekt.png" alt="dislike">
                    </div>
                    <div class="col-md-4">
                        <img class="postReactions" src="res/icons/messenger.png" alt="bruh">  
                    </div>
                </div>

            </div>
            <div class="col-md-9">

            </div>
        </div>
        <form>
            <div class="writeComment row">
            
                <div class="col-md-10">
                    <input type="text" name="comment" class="commentWrite" required placeholder="comment on this post!">
                </div>
                <div class="col-md-2">
                    <input class="btn btn-dark commentSubmit" type="submit" value="Submit">
                </div>
            
            </div>
        </form>
        <div class="row comment"> <?php //COMMENTSECTION das wird zach lol ?>

            <div class="col-md-1">
                <img class="commentProfilepic" src="res/pics/comment_dummy.jpg" />
            </div>
            <div class="col-md-11">
                <div>
                    MasterBun -14.01.20
                </div>
                <div class="commentInhalt">
                    Alter cool ein naruto-post ich mag dich jetzt best friends was passiert wenn ich diesen kommentar sehr lange mache das wäre besttimmt blöd wenn das jetzt berragen würde oder hahahahahahahahah??
        
                </div>
            </div>

        </div>
        <div>
            test
        </div>

    </div>
    <div class="col-md-3"> <?php //platzhalter ?>


    </div>
</div>
</div>




