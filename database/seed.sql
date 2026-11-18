-- =============================================================================
-- DONNÉES DE DÉMONSTRATION ET INITIALES : seed.sql
-- Base de données : speech_english
-- Projet : Speech English (Grammaire anglaise en 3 niveaux : Easy, Basic, Hard)
-- =============================================================================

USE `speech_english`;

-- -----------------------------------------------------------------------------
-- 1. Insertion des 3 Niveaux
-- -----------------------------------------------------------------------------
INSERT INTO `niveaux` (`id`, `code`, `titre`, `description`, `ordre`, `date_creation`) VALUES
(1, 'easy', 'Les temps simples', 'Niveau Débutant (Primary) : Acquérir les bases fondamentales de la conjugaison avec le Present Simple, le Past Simple et le Future Simple.', 1, NOW()),
(2, 'basic', 'Perfect & Continuous', 'Niveau Intermédiaire (College) : Maîtriser l''aspect continu et l''antériorité avec le Present Perfect, le Past Perfect et les formes en -ING.', 2, NOW()),
(3, 'hard', 'Structures avancées', 'Niveau Avancé (High School) : Perfectionner son expression avec les verbes à particule (phrasal verbs), la voix passive et les tournures de dialogue.', 3, NOW());

-- -----------------------------------------------------------------------------
-- 2. Insertion des Leçons de Grammaire
-- Chaque leçon comporte : Titre, Introduction, Explication grammaticale,
-- Règles fondamentales, Exemples en anglais et Explications en français.
-- -----------------------------------------------------------------------------
INSERT INTO `lecons` (`id`, `niveau_id`, `titre`, `slug`, `contenu`, `ordre`, `date_creation`) VALUES
-- --- NIVEAU EASY (DÉBUTANT) ---
(1, 1, 'Present Simple : Habitudes et vérités générales', 'present-simple', 
'<section class="lesson-block intro-block">
    <h3>Introduction</h3>
    <p>Le <strong>Present Simple</strong> est le premier temps fondamental à maîtriser en anglais. Il ne sert pas à décrire ce que l''on fait à la seconde même, mais à exprimer ce qui est permanent, régulier ou habituel.</p>
</section>

<section class="lesson-block grammar-block">
    <h3>Explication grammaticale</h3>
    <p>En anglais, le présent simple exprime la permanence. Contrairement au français où chaque personne change de terminaison (<em>je parle, tu parles, nous parlons</em>), l''anglais conserve la <strong>base verbale</strong> intacte à presque toutes les personnes.</p>
</section>

<section class="lesson-block rules-block">
    <h3>Règles fondamentales</h3>
    <div class="rule-card">
        <strong>Règle n°1 : La 3<sup>e</sup> personne du singulier</strong>
        <p>Avec les sujets <em>he</em>, <em>she</em>, <em>it</em> (ou un nom singulier), on ajoute obligatoirement un <strong>-s</strong> ou <strong>-es</strong> à la base verbale :</p>
        <ul>
            <li>Verbes ordinaires : <code>work &rarr; works</code>, <code>play &rarr; plays</code></li>
            <li>Verbes terminés par -s, -sh, -ch, -x, -o : <code>watch &rarr; watches</code>, <code>go &rarr; goes</code></li>
        </ul>
    </div>
    <div class="rule-card mt-2">
        <strong>Règle n°2 : Négation et interrogation avec DO / DOES</strong>
        <p>Pour poser une question ou former une négation, on utilise l''auxiliaire <strong>do</strong> (ou <strong>does</strong> à la 3e personne). Le verbe principal reste alors toujours à l''infinitif sans -s :</p>
        <ul>
            <li>Forme négative : <code>Sujet + do not (don''t) / does not (doesn''t) + Base verbale</code></li>
            <li>Forme interrogative : <code>Do / Does + Sujet + Base verbale ?</code></li>
        </ul>
    </div>
</section>

<section class="lesson-block examples-block">
    <h3>Exemples en anglais & explications en français</h3>
    <div class="example-pair">
        <div class="en-sentence">« I study English every day. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « J''étudie l''anglais tous les jours. » (Exprime une habitude quotidienne régulière).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« The sun rises in the east. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Le soleil se lève à l''est. » (Exprime une vérité scientifique générale immuable).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« She plays tennis on Sundays. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Elle joue au tennis le dimanche. » (Notez le <strong>-s</strong> obligatoire à <em>plays</em> car le sujet est <em>she</em>).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« Do you speak English? — No, I don''t speak German. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Parles-tu anglais ? — Non, je ne parle pas allemand. » (Usage des auxiliaires <em>do</em> et <em>don''t</em>).</div>
    </div>
</section>', 1, NOW()),

(2, 1, 'Past Simple : Actions passées terminées', 'past-simple', 
'<section class="lesson-block intro-block">
    <h3>Introduction</h3>
    <p>Le <strong>Past Simple</strong> (ou prétérit) est le temps du récit par excellence. On l''emploie dès lors qu''une action est complètement terminée dans le passé et souvent associée à un repère temporel précis.</p>
</section>

<section class="lesson-block grammar-block">
    <h3>Explication grammaticale</h3>
    <p>Le prétérit coupe l''action du moment présent : l''événement a eu lieu, s''est achevé, et n''a plus d''impact direct sur la situation actuelle. Les expressions courantes associées sont <em>yesterday</em> (hier), <em>last night</em> (hier soir), <em>ago</em> (il y a), ou une date précise (<em>in 2020</em>).</p>
</section>

<section class="lesson-block rules-block">
    <h3>Règles fondamentales</h3>
    <div class="rule-card">
        <strong>Règle n°1 : Verbes réguliers vs Verbes irréguliers</strong>
        <ul>
            <li><strong>Verbes réguliers :</strong> On ajoute la terminaison <strong>-ed</strong> à la base verbale (<code>visit &rarr; visited</code>, <code>watch &rarr; watched</code>).</li>
            <li><strong>Verbes irréguliers :</strong> Le verbe se transforme complètement et doit être appris par cœur dans le tableau des verbes (2e colonne : <code>go &rarr; went</code>, <code>see &rarr; saw</code>, <code>buy &rarr; bought</code>).</li>
        </ul>
    </div>
    <div class="rule-card mt-2">
        <strong>Règle n°2 : L''auxiliaire DID pour la négation et la question</strong>
        <p>Contrairement au présent, l''auxiliaire du prétérit est identique à toutes les personnes : <strong>DID</strong>. Dès que <em>did</em> est présent, le verbe repasse à la base verbale :</p>
        <ul>
            <li>Affirmatif : <code>I watched TV.</code></li>
            <li>Négatif : <code>I did not (didn''t) watch TV.</code> (Et non <s>didn''t watched</s> !)</li>
            <li>Question : <code>Did you watch TV?</code></li>
        </ul>
    </div>
</section>

<section class="lesson-block examples-block">
    <h3>Exemples en anglais & explications en français</h3>
    <div class="example-pair">
        <div class="en-sentence">« Yesterday, I visited Paris. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Hier, j''ai visité Paris. » (Verbe régulier terminé par <em>-ed</em>, action datée et révolue).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« She bought a new car last month. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Elle a acheté une nouvelle voiture le mois dernier. » (Verbe irrégulier <em>buy &rarr; bought</em>).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« Did you meet Sarah this morning? — No, I didn''t see her. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « As-tu rencontré Sarah ce matin ? — Non, je ne l''ai pas vue. » (L''auxiliaire <em>did/didn''t</em> porte la marque du passé).</div>
    </div>
</section>', 2, NOW()),

(3, 1, 'Future Simple : Décisions et prévisions avec WILL', 'future-simple', 
'<section class="lesson-block intro-block">
    <h3>Introduction</h3>
    <p>Le <strong>Future Simple</strong> permet de parler de l''avenir pour faire des prédictions, formuler des promesses ou prendre des décisions immédiates sur l''instant.</p>
</section>

<section class="lesson-block grammar-block">
    <h3>Explication grammaticale</h3>
    <p>En anglais, il n''existe pas de terminaison de futur comme en français. On associe l''auxiliaire modal <strong>will</strong> directement suivi du verbe à la base verbale (infinitif sans to).</p>
</section>

<section class="lesson-block rules-block">
    <h3>Règles fondamentales</h3>
    <div class="rule-card">
        <strong>Structure générale</strong>
        <ul>
            <li>Affirmation : <code>Sujet + will (''ll) + Base verbale</code></li>
            <li>Négation : <code>Sujet + will not (won''t) + Base verbale</code></li>
            <li>Question : <code>Will + Sujet + Base verbale ?</code></li>
        </ul>
    </div>
</section>

<section class="lesson-block examples-block">
    <h3>Exemples en anglais & explications en français</h3>
    <div class="example-pair">
        <div class="en-sentence">« Tomorrow, I will call you. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Demain, je t''appellerai. » (Promesse ferme formulée pour l''avenir).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« The phone is ringing. — I will answer it! »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Le téléphone sonne. — Je vais répondre ! » (Décision spontanée prise sur le moment).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« Don''t worry, I won''t tell anyone your secret. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Ne t''inquiète pas, je ne dirai ton secret à personne. » (Forme négative contractée <em>won''t</em>).</div>
    </div>
</section>', 3, NOW()),

-- --- NIVEAU BASIC (INTERMÉDIAIRE) ---
(4, 2, 'Present Perfect : Le lien entre passé et présent', 'present-perfect', 
'<section class="lesson-block intro-block">
    <h3>Introduction</h3>
    <p>Le <strong>Present Perfect</strong> est l''un des temps les plus typiques de la langue anglaise. Il n''a pas d''équivalent exact en français : bien qu''il se traduise souvent par un passé composé, il exprime un pont direct entre le passé et le moment présent.</p>
</section>

<section class="lesson-block grammar-block">
    <h3>Explication grammaticale</h3>
    <p>On utilise le Present Perfect quand une action accomplie dans le passé a une conséquence visible ou importante dans le présent, ou lorsqu''on dresse un bilan de son expérience de vie (avec <em>ever</em>, <em>never</em>, <em>already</em>, <em>just</em>, <em>yet</em>).</p>
</section>

<section class="lesson-block rules-block">
    <h3>Règles fondamentales</h3>
    <div class="rule-card">
        <strong>Formule : Sujet + HAVE / HAS + Participe Passé</strong>
        <ul>
            <li>Auxiliaire : <strong>have</strong> (ou <strong>has</strong> à la 3e personne du singulier).</li>
            <li>Participe passé : terminaison <strong>-ed</strong> pour les verbes réguliers, ou <strong>3<sup>e</sup> colonne</strong> pour les verbes irréguliers (<em>seen, eaten, gone, done</em>).</li>
        </ul>
    </div>
</section>

<section class="lesson-block examples-block">
    <h3>Exemples en anglais & explications en français</h3>
    <div class="example-pair">
        <div class="en-sentence">« I have just finished my homework. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Je viens tout juste de terminer mes devoirs. » (L''action est terminée, les devoirs sont prêts maintenant sur la table).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« She has lived in London for three years. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Elle vit à Londres depuis 3 ans. » (Elle a commencé il y a 3 ans et elle y habite encore aujourd''hui).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« Have you ever visited Japan? — No, I have never been there. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « As-tu déjà visité le Japon ? — Non, je n''y suis jamais allé. » (Bilan d''expérience de vie jusqu''au jour d''aujourd''hui).</div>
    </div>
</section>', 1, NOW()),

(5, 2, 'Present Continuous : L''action en cours d''accomplissement', 'present-continuous', 
'<section class="lesson-block intro-block">
    <h3>Introduction</h3>
    <p>Le <strong>Present Continuous</strong> (ou présent progressif) est utilisé pour parler d''une action qui est en train de se dérouler sous nos yeux au moment exact où l''on parle.</p>
</section>

<section class="lesson-block grammar-block">
    <h3>Explication grammaticale</h3>
    <p>Il met l''accent sur la durée ou le processus d''une activité inachevée. En français, on le traduirait souvent par la tournure <em>« être en train de + infinitif »</em>.</p>
</section>

<section class="lesson-block rules-block">
    <h3>Règles fondamentales</h3>
    <div class="rule-card">
        <strong>Formule : Sujet + BE (au présent) + Verbe en -ING</strong>
        <ul>
            <li>L''auxiliaire <strong>BE</strong> se conjugue selon le sujet : <code>I am</code>, <code>he/she/it is</code>, <code>we/you/they are</code>.</li>
            <li>Le verbe d''action prend la terminaison <strong>-ing</strong> (<code>play &rarr; playing</code>, <code>study &rarr; studying</code>).</li>
        </ul>
    </div>
</section>

<section class="lesson-block examples-block">
    <h3>Exemples en anglais & explications en français</h3>
    <div class="example-pair">
        <div class="en-sentence">« I am studying English right now. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Je suis en train d''étudier l''anglais en ce moment même. » (Action en plein déroulement).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« Look! It is raining outside. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Regarde ! Il est en train de pleuvoir dehors. » (Action observée à l''instant T).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« They are not listening to the music, they are working. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Ils n''écoutent pas de musique, ils sont en train de travailler. »</div>
    </div>
</section>', 2, NOW()),

-- --- NIVEAU HARD (AVANCÉ) ---
(6, 3, 'Phrasal Verbs : Les verbes à particule indispensables', 'phrasal-verbs', 
'<section class="lesson-block intro-block">
    <h3>Introduction</h3>
    <p>Les <strong>Phrasal Verbs</strong> (verbes à particule) sont omniprésents dans la langue anglaise quotidienne et professionnelle. Ils sont la clé pour parler de manière naturelle et fluide.</p>
</section>

<section class="lesson-block grammar-block">
    <h3>Explication grammaticale</h3>
    <p>Un phrasal verb est l''association d''un verbe classique et d''une particule (préposition ou adverbe). Cette particule transforme radicalement le sens du verbe de base : par exemple, <em>give</em> signifie « donner », mais <em>give up</em> signifie « abandonner » !</p>
</section>

<section class="lesson-block rules-block">
    <h3>Règles & Verbes incontournables</h3>
    <div class="rule-card">
        <strong>Les 4 phrasal verbs indispensables :</strong>
        <ul>
            <li><strong>Give up :</strong> Abandonner / renoncer</li>
            <li><strong>Look forward to :</strong> Attendre avec impatience / avoir hâte de</li>
            <li><strong>Run into :</strong> Croiser quelqu''un par hasard</li>
            <li><strong>Put off :</strong> Reporter / ajourner à plus tard</li>
        </ul>
    </div>
</section>

<section class="lesson-block examples-block">
    <h3>Exemples en anglais & explications en français</h3>
    <div class="example-pair">
        <div class="en-sentence">« Never give up on your goals. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « N''abandonne jamais tes objectifs. » (<em>Give up</em> = cesser ses efforts, capituler).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« I really look forward to hearing from you. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « J''ai vraiment hâte d''avoir de vos nouvelles. » (Formule courante très polie en fin d''email).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« I ran into an old friend at the train station. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « J''ai croisé un vieil ami par hasard à la gare. » (<em>Run into</em> au prétérit : <em>ran into</em>).</div>
    </div>
</section>', 1, NOW()),

(7, 3, 'La Voix Passive : Structure et usage en contexte formel', 'passive-voice', 
'<section class="lesson-block intro-block">
    <h3>Introduction</h3>
    <p>La <strong>Voix Passive</strong> (Passive Voice) est fréquemment employée dans les rapports formels, les articles de presse, les sciences et les contextes professionnels pour donner un ton objectif et impersonnel.</p>
</section>

<section class="lesson-block grammar-block">
    <h3>Explication grammaticale</h3>
    <p>Dans une phrase active, le sujet accomplit l''action. Dans une phrase passive, le sujet <strong>subit</strong> l''action. On utilise la voix passive lorsque l''auteur de l''action est inconnu, sans importance, ou lorsque l''on souhaite mettre en avant l''objet de l''action.</p>
</section>

<section class="lesson-block rules-block">
    <h3>Règles de transformation</h3>
    <div class="rule-card">
        <strong>Formule : Sujet + BE (au temps actif) + Participe Passé (+ by + complément d''agent)</strong>
        <ul>
            <li>Actif : <em>The teacher explained the lesson.</em> (Le sujet <em>The teacher</em> fait l''action).</li>
            <li>Passif : <em>The lesson <strong>was explained</strong> by the teacher.</em> (L''objet <em>The lesson</em> devient sujet et subit l''explication).</li>
        </ul>
    </div>
</section>

<section class="lesson-block examples-block">
    <h3>Exemples en anglais & explications en français</h3>
    <div class="example-pair">
        <div class="en-sentence">« The project was approved by the manager yesterday. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « Le projet a été approuvé par le responsable hier. » (L''accent est mis sur le projet plutôt que sur le manager).</div>
    </div>
    <div class="example-pair">
        <div class="en-sentence">« English is spoken in many countries around the world. »</div>
        <div class="fr-explanation">&rarr; <strong>Français :</strong> « L''anglais est parlé dans de nombreux pays à travers le monde. » (L''agent « par les gens » est omis car évident).</div>
    </div>
</section>', 2, NOW());

-- -----------------------------------------------------------------------------
-- 3. Insertion des 7 Quiz associés aux Leçons
-- -----------------------------------------------------------------------------
INSERT INTO `quiz` (`id`, `lecon_id`, `titre`, `description`, `date_creation`) VALUES
(1, 1, 'Quiz 1 : Present Simple', 'Évaluez vos réflexes sur les habitudes et la 3e personne du singulier.', NOW()),
(2, 2, 'Quiz 2 : Past Simple', 'Validez l''emploi des verbes réguliers et irréguliers au prétérit.', NOW()),
(3, 3, 'Quiz 3 : Future Simple', 'Vérifiez la construction des promesses et décisions avec Will.', NOW()),
(4, 4, 'Quiz 4 : Present Perfect', 'Maîtrisez l''auxiliaire Have/Has et l''expression du bilan.', NOW()),
(5, 5, 'Quiz 5 : Present Continuous', 'Validez l''accord de l''auxiliaire BE et la forme en -ING.', NOW()),
(6, 6, 'Quiz 6 : Phrasal Verbs', 'Démontrez votre maîtrise du sens des verbes à particule.', NOW()),
(7, 7, 'Quiz 7 : Passive Voice', 'Testez la restructuration passive et les participes passés.', NOW());

-- -----------------------------------------------------------------------------
-- 4. Insertion des Questions de Quiz avec Explications Pédagogiques
-- -----------------------------------------------------------------------------
-- Quiz 1 (Present Simple)
INSERT INTO `questions` (`id`, `quiz_id`, `enonce`, `explication`, `points`, `ordre`, `date_creation`) VALUES
(1, 1, 'She ____ (play) tennis every Saturday morning.', 'Au Present Simple avec le sujet « She » (3e personne du singulier), le verbe prend obligatoirement la marque « -s » : plays.', 1, 1, NOW()),
(2, 1, '____ they speak English during the meeting?', 'Pour poser une question au Present Simple avec le sujet pluriel « they », on utilise l''auxiliaire « Do ».', 1, 2, NOW()),
(3, 1, 'Thomas ____ (not / like) drinking cold coffee.', 'À la forme négative avec la 3e personne du singulier (he), on emploie l''auxiliaire « doesn''t » suivi de la base verbale « like » sans -s.', 1, 3, NOW());

-- Quiz 2 (Past Simple)
INSERT INTO `questions` (`id`, `quiz_id`, `enonce`, `explication`, `points`, `ordre`, `date_creation`) VALUES
(4, 2, 'Yesterday, we ____ (visit) the national museum.', 'Pour un verbe régulier au Past Simple comme « visit », on ajoute simplement la terminaison « -ed » : visited.', 1, 1, NOW()),
(5, 2, 'Last week, she ____ (buy) a new laptop for university.', 'Le verbe « buy » est irrégulier : sa forme au Past Simple est « bought » (2e colonne du tableau des verbes irréguliers).', 1, 2, NOW()),
(6, 2, 'Did you ____ your keys on the table this morning?', 'Après l''auxiliaire « did » au prétérit, le verbe principal reste obligatoirement à la base verbale (infinitif sans to) : find.', 1, 3, NOW());

-- Quiz 3 (Future Simple)
INSERT INTO `questions` (`id`, `quiz_id`, `enonce`, `explication`, `points`, `ordre`, `date_creation`) VALUES
(7, 3, 'Tomorrow at 8 AM, I ____ (call) you back.', 'Le Future Simple se forme avec l''auxiliaire modal « will » suivi de la base verbale : will call.', 1, 1, NOW()),
(8, 3, 'Don''t worry, we ____ (not / forget) our promise.', 'La forme négative contractée de « will not » est « won''t ».', 1, 2, NOW()),
(9, 3, '____ you help me with this heavy suitcase, please?', 'Pour demander un service ou une décision spontanée au futur, on utilise l''inversion « Will you... ? ».', 1, 3, NOW());

-- Quiz 4 (Present Perfect)
INSERT INTO `questions` (`id`, `quiz_id`, `enonce`, `explication`, `points`, `ordre`, `date_creation`) VALUES
(10, 4, 'I ____ (just / finish) reading this grammar book.', 'Avec le sujet « I », on emploie l''auxiliaire « have » suivi du participe passé « finished » : have just finished.', 1, 1, NOW()),
(11, 4, 'He ____ (live) in Canada since 2021.', 'Avec la 3e personne du singulier « He », on accorde l''auxiliaire avec « has » : has lived.', 1, 2, NOW()),
(12, 4, 'Have you ever ____ (see) this movie before?', 'Après l''auxiliaire have au Present Perfect, on utilise le participe passé irrégulier du verbe see : « seen » (3e colonne).', 1, 3, NOW());

-- Quiz 5 (Present Continuous)
INSERT INTO `questions` (`id`, `quiz_id`, `enonce`, `explication`, `points`, `ordre`, `date_creation`) VALUES
(13, 5, 'Look at the sky! It ____ (rain) right now.', 'Pour exprimer une action en cours avec « it », on utilise l''auxiliaire BE « is » + verbe en -ing : is raining.', 1, 1, NOW()),
(14, 5, 'They ____ (study) in the library at the moment.', 'Avec le sujet pluriel « they », on utilise « are » + verbe en -ing : are studying.', 1, 2, NOW());

-- Quiz 6 (Phrasal Verbs)
INSERT INTO `questions` (`id`, `quiz_id`, `enonce`, `explication`, `points`, `ordre`, `date_creation`) VALUES
(15, 6, 'You must never ____ on your ambitions and dreams!', 'Le phrasal verb « give up » signifie capituler ou abandonner.', 1, 1, NOW()),
(16, 6, 'I really look ____ to meeting your new colleagues.', 'L''expression consacrée est « look forward to », qui signifie attendre avec joie ou avoir hâte de.', 1, 2, NOW()),
(17, 6, 'Yesterday, I ____ into my English teacher at the supermarket.', 'Le phrasal verb « run into » au passé donne « ran into », signifiant croiser quelqu''un par hasard.', 1, 3, NOW());

-- Quiz 7 (Passive Voice)
INSERT INTO `questions` (`id`, `quiz_id`, `enonce`, `explication`, `points`, `ordre`, `date_creation`) VALUES
(18, 7, 'The famous novel ____ (write) by George Orwell in 1949.', 'Au passé à la voix passive avec un sujet singulier, on emploie « was » suivi du participe passé « written » : was written.', 1, 1, NOW()),
(19, 7, 'English ____ (speak) by millions of people worldwide.', 'Au présent simple passif, on utilise « is » suivi du participe passé irrégulier de speak : is spoken.', 1, 2, NOW());

-- -----------------------------------------------------------------------------
-- 5. Insertion des Propositions de Réponses (QCM)
-- -----------------------------------------------------------------------------
-- Question 1 (plays)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(1, 'plays', 1, NOW()),
(1, 'play', 0, NOW()),
(1, 'playing', 0, NOW()),
(1, 'played', 0, NOW());

-- Question 2 (Do)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(2, 'Do', 1, NOW()),
(2, 'Does', 0, NOW()),
(2, 'Are', 0, NOW()),
(2, 'Have', 0, NOW());

-- Question 3 (doesn't like)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(3, 'doesn''t like', 1, NOW()),
(3, 'don''t like', 0, NOW()),
(3, 'isn''t like', 0, NOW()),
(3, 'not likes', 0, NOW());

-- Question 4 (visited)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(4, 'visited', 1, NOW()),
(4, 'visit', 0, NOW()),
(4, 'have visited', 0, NOW()),
(4, 'visiting', 0, NOW());

-- Question 5 (bought)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(5, 'bought', 1, NOW()),
(5, 'buyed', 0, NOW()),
(5, 'buys', 0, NOW()),
(5, 'was buy', 0, NOW());

-- Question 6 (find)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(6, 'find', 1, NOW()),
(6, 'found', 0, NOW()),
(6, 'finding', 0, NOW()),
(6, 'finds', 0, NOW());

-- Question 7 (will call)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(7, 'will call', 1, NOW()),
(7, 'calls', 0, NOW()),
(7, 'called', 0, NOW()),
(7, 'am call', 0, NOW());

-- Question 8 (won't forget)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(8, 'won''t forget', 1, NOW()),
(8, 'don''t forget', 0, NOW()),
(8, 'will not to forget', 0, NOW()),
(8, 'not will forget', 0, NOW());

-- Question 9 (Will)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(9, 'Will', 1, NOW()),
(9, 'Do', 0, NOW()),
(9, 'Are', 0, NOW()),
(9, 'Did', 0, NOW());

-- Question 10 (have just finished)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(10, 'have just finished', 1, NOW()),
(10, 'has just finished', 0, NOW()),
(10, 'just finished', 0, NOW()),
(10, 'am just finished', 0, NOW());

-- Question 11 (has lived)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(11, 'has lived', 1, NOW()),
(11, 'have lived', 0, NOW()),
(11, 'is living', 0, NOW()),
(11, 'lived', 0, NOW());

-- Question 12 (seen)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(12, 'seen', 1, NOW()),
(12, 'saw', 0, NOW()),
(12, 'seed', 0, NOW()),
(12, 'seeing', 0, NOW());

-- Question 13 (is raining)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(13, 'is raining', 1, NOW()),
(13, 'rains', 0, NOW()),
(13, 'raining', 0, NOW()),
(13, 'was rain', 0, NOW());

-- Question 14 (are studying)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(14, 'are studying', 1, NOW()),
(14, 'is studying', 0, NOW()),
(14, 'study', 0, NOW()),
(14, 'studies', 0, NOW());

-- Question 15 (give up)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(15, 'give up', 1, NOW()),
(15, 'give in', 0, NOW()),
(15, 'give off', 0, NOW()),
(15, 'give away', 0, NOW());

-- Question 16 (forward)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(16, 'forward', 1, NOW()),
(16, 'ahead', 0, NOW()),
(16, 'front', 0, NOW()),
(16, 'after', 0, NOW());

-- Question 17 (ran into)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(17, 'ran into', 1, NOW()),
(17, 'run into', 0, NOW()),
(17, 'ran away', 0, NOW()),
(17, 'running to', 0, NOW());

-- Question 18 (was written)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(18, 'was written', 1, NOW()),
(18, 'is written', 0, NOW()),
(18, 'wrote', 0, NOW()),
(18, 'has wrote', 0, NOW());

-- Question 19 (is spoken)
INSERT INTO `propositions_reponses` (`question_id`, `texte_reponse`, `est_correcte`, `date_creation`) VALUES
(19, 'is spoken', 1, NOW()),
(19, 'speaks', 0, NOW()),
(19, 'was spoken', 0, NOW()),
(19, 'is speaking', 0, NOW());

-- -----------------------------------------------------------------------------
-- 6. Utilisateurs de Démonstration (mot de passe "password123")
-- -----------------------------------------------------------------------------
INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_creation`) VALUES
(1, 'Kouassi', 'Ange', 'ange.kouassi@speech-english.local', '$2y$10$VPFOZeOpOg0MjLe0VPQViO7Nar.93eW72Hyt2TsIg3mRg7DlqycxG', NOW()),
(2, 'Touré', 'Amina', 'amina.toure@speech-english.local', '$2y$10$VPFOZeOpOg0MjLe0VPQViO7Nar.93eW72Hyt2TsIg3mRg7DlqycxG', NOW());

-- -----------------------------------------------------------------------------
-- 7. Historique initial des Tentatives
-- -----------------------------------------------------------------------------
INSERT INTO `tentatives_quiz` (`utilisateur_id`, `quiz_id`, `score_obtenu`, `score_max`, `bonnes_reponses`, `mauvaises_reponses`, `pourcentage`, `date_tentative`) VALUES
(1, 1, 3, 3, 3, 0, 100.00, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(1, 2, 2, 3, 2, 1, 66.67, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(2, 1, 2, 3, 2, 1, 66.67, DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(2, 4, 3, 3, 3, 0, 100.00, NOW());

-- -----------------------------------------------------------------------------
-- 8. Suivi de Progression par Leçon
-- -----------------------------------------------------------------------------
INSERT INTO `progression_lecons` (`utilisateur_id`, `lecon_id`, `statut`, `date_derniere_consultation`, `date_completion`) VALUES
(1, 1, 'termine', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(1, 2, 'termine', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY)),
(1, 3, 'en_cours', NOW(), NULL),
(2, 1, 'termine', DATE_SUB(NOW(), INTERVAL 3 HOUR), DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(2, 4, 'termine', NOW(), NOW());
