
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

<section>
<div class="row">
    <div class="col-md-3"> <?php //platzhalter mit back-button ?>
    </div>
    <div class="col-md-6"> <?php //Post mit comments lets gooooo hype it up man ?>
        <div class="row"> <?php //oben profil und menupunkte ?>
            <div>
                <div>
                    <?php //PROFILEPIC ?>
                </div>
                <div>
                    <?php //USERNAME (evtl clickable um zum jeweiligen Profil zu gelangen) ?>
                </div>
            </div>
            <div>
                <?php //MENUBUTTON für löschen etc LINKS ANORDNEN ?>
            </div>
        </div>
        <div> <?php //BILD/GRAFIK/NUDES/WASWEISSICH ?>
            <img src="" alt="">
        </div>
        <div> <?php //COMMENTSECTION das wird zach lol ?>
        </div>
    </div>
    <div class="col-md-3"> <?php //platzhalter mit löschdingsbums ?>
    </div>
</div>


</section>