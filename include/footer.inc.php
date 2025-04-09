
    </main>

        <footer>
        <span> @Fariza FARADJI - Céline Boukersi - Cergy Université - 2025</span>
            <span>Vous êtes sur <?= get_navigateur() ?> </span>
            <span><a href="plan_du_site.php<?=$mode.$language?>" >Plan du site</a></span>
			<span><a href="tech.php<?=$mode.$language?>">Page Tech</a></span>
            <span><a href="#" id="manage-cookies" style="color: #007bff;">Gérer les cookies</a></span>
        </footer>

    <div id="cookie-consent" style="display: none; position: fixed; bottom: 0; background: #eee; padding: 15px; width: 100%; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); z-index: 999;">
        Ce site utilise des cookies pour améliorer votre expérience.
        <button id="accept-cookies">Accepter</button>
        <button id="decline-cookies">Refuser</button>
        <a href="#" id="manage-cookies" style="margin-left: 10px;">Gérer les cookies</a>
    </div>


    </body>

</html>