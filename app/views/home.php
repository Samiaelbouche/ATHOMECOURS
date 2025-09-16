<?php include '../partial/header.php'; ?>

<main>


    <section class="banner">
        <img src="../images/ChatGPT%20Image%2025%20juil.%202025,%2010_38_11.png" alt="Bannière" class="banner-img">
        <div class="banner-text">
            <h1> At Home Cours :l'atome de la réussite</h1>
            <p>Trouvez le professeur de Physique Chimie qui vous correspond</p>
            <a href="../template/inscription.html" class="btn">S'inscrire</a>
        </div>
    </section>

    <section class="cours">
        <h2>Nos cours</h2>
        <div class="cours-grid">
            <article class="cours-card">
                <img src="images/cours-en-ligne.jpg" alt="Cours en ligne">
                <h3>Cours en ligne</h3>
                <p>Suivez vos cours de physique-chimie à distance avec nos professeurs, en direct ou en replay, où que vous soyez.</p>
                <a href="noscours.php" class="btn">En savoir plus</a>
            </article>

            <article class="cours-card">
                <img src="images/cours-domicile.jpg" alt="Cours à domicile">
                <h3>Cours à domicile</h3>
                <p>Bénéficiez d’un accompagnement personnalisé chez vous, avec un professeur qualifié qui se déplace.</p>
                <a href="cours-domicile.php" class="btn">En savoir plus</a>
            </article>
        </div>
    </section>
    <section class="about">
        <h2>Qui sommes-nous ?</h2>
        <div class="about-content">
            <img src="images/qui-sommes-nous.jpg" alt="Notre équipe">
            <div class="about-text">
                <p>
                    Chez <strong>At Home Cours</strong>, nous sommes une équipe passionnée de professeurs de physique-chimie,
                    dédiée à aider les élèves du collège au lycée à réussir et à s’épanouir dans leurs études.
                </p>
                <p>
                    Nous proposons des cours <em>en ligne</em> et <em>à domicile</em>, adaptés au rythme et aux besoins de chacun.
                    Notre pédagogie repose sur la clarté, la patience et des méthodes éprouvées pour rendre les sciences accessibles à tous.
                </p>
                <p>
                    Grâce à des <strong>stages de révision</strong>, des <strong>fiches claires</strong> et un <strong>accompagnement personnalisé</strong>,
                    nous visons à donner confiance aux élèves et à leur permettre d’atteindre leurs objectifs scolaires.
                </p>
            </div>
        </div>
    </section>

    <section class="professeurs">
        <h2>Nos professeurs</h2>
        <div class="prof-grid">
            <div class="prof-card">
                <img src="images/.jpg" alt="Professeur">
                <p><strong>nom prenom</strong></p>
            </div>
            <div class="prof-card">
                <img src="" alt="Professeur">
                <p><strong> nom prenom</strong></p>
            </div>
            <div class="prof-card">
                <img src="" alt="Professeur">
                <p><strong>nom prenom</strong></p>
            </div>
        </div>
    </section>


    <section class="temoignages">
        <h2>Témoignages</h2>
        <div class="slider">
            <div class="slide active">
                <img src="images/eleve1.jpg" alt="Élève">
                <p>"Super cours, j’ai beaucoup progressé !"</p>
                <span>- Thomas</span>
            </div>
            <div class="slide">
                <img src="images/eleve2.jpg" alt="Élève">
                <p>"Les profs sont très pédagogues."</p>
                <span>- Julie</span>
            </div>
            <div class="slide">
                <img src="images/eleve3.jpg" alt="Élève">
                <p>"Je recommande à 100%."</p>
                <span>- Karim</span>
            </div>
        </div>

        <div class="slider-controls">
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </section>

</main>

<?php include '../partial/footer.php'; ?>



