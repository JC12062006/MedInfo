<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- STyles -->    
    <link rel="stylesheet" href="public/styles.connexion.css">
    <link rel="stylesheet" href="public/styles.inscription.css">
    <link rel="stylesheet" href="public/styles.mdpOublie.css">
    <link rel="stylesheet" href="public/styles.reinitialisationMdp.css">
    <link rel="stylesheet" href="public/styles.accueil.css">
    <link rel="stylesheet" href="public/styles.header.css">
    <link rel="stylesheet" href="public/styles.footer.css">


    <title>MedInfo</title>
</head>
<body>

<header class="medinfo-header">
    <div class="medinfo-header-inner">
        <!-- Logo MedInfo (on réutilise le style existant) -->
        <a href="index.php" class="medinfo-logo">
            <span class="medinfo-logo-icon">M</span>
            <span class="medinfo-logo-text">MedInfo</span>
        </a>

        <!-- Toggle mobile -->
        <input type="checkbox" id="medinfo-nav-toggle" class="medinfo-nav-toggle">
        <label for="medinfo-nav-toggle" class="medinfo-nav-burger" aria-label="Ouvrir la navigation">
            <span class="medinfo-nav-burger-lines"></span>
        </label>

        <!-- Nav + actions -->
        <div class="medinfo-header-right">
            <nav class="medinfo-nav" aria-label="Navigation principale">

                <a href="index.php?page=accueil" class="medinfo-nav-link medinfo-nav-link--active">Accueil</a>
                <?php if(!empty($_SESSION['user'])){
                            if($_SESSION['user']['role'] == 'Patient'){?>
                                <a href="index.php?page=prendreRdv" class="medinfo-nav-link">Prendre rendez-vous</a>
                                <a href="index.php?page=medecins" class="medinfo-nav-link">Médecins</a>
                            <?php }else{ ?>
                                <a href="index.php?page=profilMedecin" class="medinfo-nav-link">Mon agenda</a>
                                <a href="index.php?page=demandesRdv" class="medinfo-nav-link">Gestion Rendez-Vous</a>
                                <a href="index.php?page=consultationMedecin" class="medinfo-nav-link">Historique Consultations</a>
                                <a href="index.php?page=consultationMedecin" class="medinfo-nav-link">Demarrer une Consultations</a>
                            <?php } ?>
                <?php } ?>
            </nav>
            <?php if(empty($_SESSION['user'])){?>
            <div class="medinfo-header-actions">
                <a href="index.php?page=connexion">
                    <button type="button" class="medinfo-btn-ghost">
                        Connexion
                    </button>
                </a>
                <a href="index.php?page=inscription">
                    <button type="button" class="medinfo-btn-primary-nav">
                        S’inscrire
                    </button>
                </a>
            </div>
            <?php  }else{?>
                <div class="medinfo-header-actions">
                <a href="index.php?page=deconnexion">
                    <button type="button" class="medinfo-btn-primary-nav">
                        Déconnexion
                    </button>
                </a>
            </div>
            <?php }?>    
        </div>
    </div>
</header>
