<?php
require_once ROOT . 'controller/rendez_vous/controller.rdv.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre un rendez-vous - MedInfo</title>
</head>
<body>

<main class="rdv-container">
    <section class="rdv-section">
        <h2>📅 Prendre un rendez-vous</h2>
        <p>Choisissez un créneau disponible et précisez le motif de votre consultation.</p>

        <form action="index.php?page=controller.rdv" method="POST" class="rdv-form">

            <!-- Sélection du créneau -->
            <div class="rdv-form-group">
                <label for="id_creneau">Créneau disponible <span class="required">*</span></label>
                <select id="id_creneau" name="id_creneau" required>
                    <option value="">-- Sélectionnez un créneau --</option>
                    <?php if (!empty($creneaux)): ?>
                        <?php foreach ($creneaux as $c): ?>
                            <option value="<?= htmlspecialchars($c['id_creneau']); ?>">
                                <?= date('d/m/Y H:i', strtotime($c['date_heure_debut'])); ?> 
                                avec Dr. <?= htmlspecialchars($c['medecin_nom']); ?> <?= htmlspecialchars($c['medecin_prenom']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>Aucun créneau disponible pour le moment</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Motif -->
            <div class="rdv-form-group">
                <label for="motif">Motif du rendez-vous <span class="required">*</span></label>
                <textarea id="motif" name="motif" rows="4" placeholder="Ex: Consultation annuelle, suivi traitement..." required></textarea>
            </div>

            <!-- Champs cachés -->
            <input type="hidden" name="origine" value="patient">
            <input type="hidden" name="id_patient" value="<?= $_SESSION['user']['id_utilisateur']; ?>">
            <input type="hidden" name="action" value="ajouter">

            <!-- Bouton -->
            <div class="rdv-form-actions">
                <button type="submit" class="btn-primary">✅ Confirmer ma demande</button>
            </div>
        </form>
    </section>
</main>

</body>
</html>
