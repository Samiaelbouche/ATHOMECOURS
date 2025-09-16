<?php
include '../partial/header.php'; ?>

<main>
    <section class="banner">
        <img src="../images/images%20(1).jpeg" alt="Bannière" class="banner-img">
        <div class="banner-text">
            <h1> Découvrez nos formules de cours adaptées à vos besoins et à votre budget.</h1>
            <p>
                Que vous préfériez le présentiel ou l’en ligne, nous avons une solution pour vous !</p>

        </div>
    </section>

    <section>

        <div class="tarifs-grid">

             <article class="tarif-card">
                <h2>Cours à domicile</h2>
                <p><strong>Séance de 1h30</strong></p>
                <p class="price">35 €</p>
                <a href="../views/inscriptionEleveView.php" class="btn">S'inscrire</a>
            </article>


            <article class="tarif-card">
                <h2>Cours en ligne</h2>
                <p><strong>Séance de 1h30</strong></p>
                <p class="price">30 €</p>
                <a href="../views/inscriptionEleveView.php" class="btn">S'inscrire</a>
            </article>


            <article class="tarif-card">
                <h2>Forfait en ligne</h2>
                <p><strong>2 créneaux / semaine</strong><br>pendant 1 mois</p>
                <p class="price">150 €</p>
                <a href="../views/inscriptionEleveView.php" class="btn">S'inscrire</a>
            </article>


            <article class="tarif-card">
                <h2>Forfait à domicile</h2>
                <p><strong>2 créneaux / semaine</strong><br>pendant 1 mois</p>
                <p class="price">200 €</p>
                <a href="../views/inscriptionEleveView.php" class="btn">S'inscrire</a>
            </article>

        </div>

    </section>

</main>
<?php include '../partial/footer.php'; ?>