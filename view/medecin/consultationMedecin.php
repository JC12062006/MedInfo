<?php
// Exemple de données (Simule ta récupération SQL)
$consultations = [
    [
        'date' => '05/12/2024',
        'heure' => '09:30',
        'patient' => 'Jean Dupont',
        'motif' => 'Douleurs abdominales',
        'tension' => '120/80',
        'poids' => '75 kg'
    ],
    [
        'date' => '04/12/2024',
        'heure' => '14:15',
        'patient' => 'Sophie Martin',
        'motif' => 'Renouvellement ordonnance',
        'tension' => '118/75',
        'poids' => '62 kg'
    ],
    [
        'date' => '04/12/2024',
        'heure' => '11:00',
        'patient' => 'Marc Alibert',
        'motif' => 'Suivi diabète',
        'tension' => '130/85',
        'poids' => '88 kg'
    ],
];
?>

<div class="medinfo-history-wrapper">
    <div class="medinfo-history-header">
        <h2>Historique des Consultations</h2>
        <p>Retrouvez ci-dessous les derniers examens réalisés.</p>
    </div>

    <div class="table-responsive">
        <table class="medinfo-table">
            <thead>
                <tr>
                    <th>Date & Heure</th>
                    <th>Patient</th>
                    <th>Motif</th>
                    <th>Constantes (Tension/Poids)</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $row): ?>
                <tr>
                    <td data-label="Date & Heure">
                        <span class="date-badge">
                            <?php echo $row['date']; ?> <small>à <?php echo $row['heure']; ?></small>
                        </span>
                    </td>
                    <td data-label="Patient">
                        <strong><?php echo $row['patient']; ?></strong>
                    </td>
                    <td data-label="Motif" class="text-muted">
                        <?php echo $row['motif']; ?>
                    </td>
                    <td data-label="Constantes">
                        <span class="constante-tag"><?php echo $row['tension']; ?></span>
                        <span class="constante-tag"><?php echo $row['poids']; ?></span>
                    </td>
                    <td data-label="Actions" style="text-align: right;">
                        <a href="#" class="btn-table-action">Voir fiche</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if (empty($consultations)): ?>
        <div class="empty-state">Aucune consultation enregistrée pour le moment.</div>
    <?php endif; ?>
</div>