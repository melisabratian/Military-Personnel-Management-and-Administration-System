<?php
include_once("../Header.php"); 
?>

<style>
    body {
        background-image: url("../images/about_us.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        color: white;
    }

    .overlay {
        background-color: rgba(0, 0, 0, 0.75);
        padding: 40px 20px;
    }

    .section {
        background-color: white;
        color: black;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
        margin-bottom: 40px;
    }

    .image-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .image-row img {
        max-width: 300px;
        border: 3px solid white;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(255,255,255,0.4);
    }

    .highlight {
        background-color: #ffeb3b;
        color: #000;
        padding: 10px;
        font-weight: bold;
        border-radius: 5px;
        display: inline-block;
        margin-top: 10px;
    }

    .emblem-section img {
        max-width: 200px;
        margin-top: 20px;
    }

</style>

<div class="overlay container">

    <div class="section text-center">
        <h2>About the Infantry</h2>
        <p>
            <strong>Mountain Infantry (Vânătorii de munte)</strong> are a military specialty within the Romanian Land Forces,
            part of the infantry. These elite units are trained to carry out operations independently or in coordination with other forces,
            particularly in mountainous and forested terrain, under all weather and seasonal conditions.
        </p>
        <div class="image-row">
            <img src="../images/about_us2.jpg" alt="Mountain Troops">
            <img src="../images/about_us3.jpg" alt="Training">
        </div>
    </div>
    




    <div class="section">
        <h3>📍 Operational Mountain Brigades</h3>
        <p><strong>Romanian Land Forces</strong> currently operate two Mountain Hunter Brigades:</p>

        <ul>
            <li><strong>2nd Mountain Infantry Brigade "Sarmizegetusa"</strong> – Brașov (subordinated to the 1st Infantry Division "Dacica")
    <ul>
        <li>21st Battalion "General Leonard Mociulschi" – Predeal</li>
        <li>30th Battalion "Dragoslavele" – Câmpulung Muscel</li>
        <li>33rd Battalion "Posada" – Curtea de Argeș</li>
        <li>206th Artillery Division – Ghimbav</li>
        <li>228th Air Defense Division "Piatra Craiului" – Brașov</li>
        <li>229th Logistics Battalion</li>
    </ul>
</li>
<li><strong>61st Mountain Infantry Brigade "General Virgil Bădulescu"</strong> – Miercurea Ciuc (subordinated to the 4th Infantry Division "Gemina")
    <ul>
        <li>17th Battalion "Dragoș Vodă" – Vatra Dornei</li>
        <li><span class="highlight">22nd Mountain Infantry Battalion "Cireșoaia" – Sfântu Gheorghe</span></li>
        <li>24th Battalion "General Gheorghe Avramescu" – Miercurea Ciuc</li>
        <li>26th Battalion "Avram Iancu" – Brad</li>
        <li>385th Artillery Division "Iancu de Hunedoara"</li>
        <li>468th Air Defense Division "Trotuș"</li>
        <li>435th Logistics Battalion "Ciuc"</li>
    </ul>
</li>

        </ul>
    </div>

    <div class="section emblem-section text-center">
        <h3>🎖 Emblem of the 22nd Mountain Infantry Battalion</h3>
        <p>
            <em>
                A badge honoring the commitment and unity within the <strong>22nd Mountain Infantry Battalion „Cireșoaia”</strong>.
                Crafted with pride and respect for the traditions of this distinguished military unit, the embroidered emblem
                authentically symbolizes camaraderie and courage. Finished with attention to detail and made from high-quality materials,
                this emblem is a proud addition to military uniforms and gear. Each stitch represents our commitment to honor and the
                values of the <strong>22nd Mountain Infantry Battalion „Cireșoaia”</strong>.
            </em>
        </p>
        <img src="../images/emblema22.jpg" alt="Unit Emblem">
    </div>

</div>

<?php include("../Footer.php"); ?>


