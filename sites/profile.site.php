<?php /*
IDEEN FÜR PROFILE
.) Setting-Button nur sichbar, solange der eingeloggte user, derselbe user ist, den man sich anschaut (simple if-stmt)

.) Wie weiß man, auf welche person geklickt wurde?
   Lösungsvorschlag: wen man auf ein profil im feed klickt, dann wird eine klasse von diesem account erstellt,
   damit das system, weiß welches profil es in der profilepage anzeigen soll (beispielname: visitor).
   Nachdem man das Profil von der Person verlassen hat, wird die Klasse gelöscht.

.) Userfeed mit for-Schleife (mit SQL-query zählen, wie viele Posts der User hat)

*/
?>

<section id="profile">

<div class="row">
    <div class="col-3" id="profileLeft"> <?php //profilsettings links schmale Spalte ?>
        <div> <?php //PROFILEPIC ?>
            <div class="container">
	            <div class="row">
                    <div class="profile-header-container">   
    		            <div class="profile-header-img">
                            <img class="img-circle" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" />
                <!-- badge -->
                            <div class="rank-label-container">
                                <span class="label label-default rank-label">trylikeabun</span>
                            </div>
                        </div>
                    </div> 
	            </div>
            </div>
        </div>
        <!--<div> <?php //USERNAME ?>
        </div>-->
        <div> <?php //MENU ?>
            <div class="sidebar-item"> <?php //menupunkt: profile ?>
                <a href="#" class="sidebar-link">
                    <span class="sidebar-link-concept">PROFILE</span>
                </a>
            </div>
            <div class="sidebar-item"> <?php //menupunkt: settings (MIT IF SATEMENT weil nur eingeloggter user sehen kann) ?>
                <a href="#" class="sidebar-link">
                    <span class="sidebar-link-concept">SETTINGS</span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-9"> <?php //profilübersicht posts/einstellungen ?>
    </div>
</div>









</section> <?php // ?>