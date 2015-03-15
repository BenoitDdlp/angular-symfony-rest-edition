<?php
namespace asre\ImportBundle\Command;

use asre\CommunityBundle\Entity\Person;
use asre\ContentBundle\Entity\Location;
use asre\ContentBundle\Entity\Topic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Initialization command for the DataBase
 *
 * Class databaseInitCommand
 *
 * @package asre\EventBundle\Command
 */
class databaseInitCommand extends ContainerAwareCommand
{

  protected function configure()
  {
    $this
      ->setName('asre:database:init')
      ->setDescription('Insert datas');
  }

  /**
   * Executes the current command.
   *
   * This method is not abstract because you can use this class
   * as a concrete class. In this case, instead of defining the
   * execute() method, you set the code to execute by passing
   * a Closure to the setCode() method.
   *
   * @param InputInterface  $input  An InputInterface instance
   * @param OutputInterface $output An OutputInterface instance
   *
   * @return null|integer null or 0 if everything went fine, or an error code
   *
   * @throws \LogicException When this abstract method is not implemented
   * @see    setCode()
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    /** @var \asre\SecurityBundle\Entity\User $admin */
    $admin = $this->getContainer()->get("fos_user.user_manager")->findUserByUsername("admin");

    $em = $this->getContainer()->get('doctrine')->getManager('default');

    $this->createData($em);


    $em->flush();

    $output->writeln("data inserted successfully");
  }

  /**
   * @param EntityManagerInterface $em
   */
  private function createData(EntityManagerInterface $em)
  {


    /***** Location *******/
    $location = new Location();
    $location->setAddress("Lyon, France");
    $location->setLabel("Lyon, France");
    $location->setCity("Lyon");
    $location->setCountry("France");
    $em->persist($location);

    /***** Topics *******/
    $business = new Topic();
    $business->setLabel("Business");
    $em->persist($business);

    $design = new Topic();
    $design->setLabel("Design");
    $em->persist($design);

    $marketing = new Topic();
    $marketing->setLabel("Marketing");
    $em->persist($marketing);

    $recherche = new Topic();
    $recherche->setLabel("Recherche");
    $em->persist($recherche);

    $tech = new Topic();
    $tech->setLabel("Tech");
    $em->persist($tech);


    /***** Locations *******/
    $auditorium = new Location();
    $auditorium->setLabel("Auditorium");
    $auditorium->setCapacity(1000);
    $em->persist($auditorium);

    $salonGratteCiel = new Location();
    $salonGratteCiel->setLabel("Grand Salon Gratte Ciel");
    $salonGratteCiel->setCapacity(200);
    $em->persist($salonGratteCiel);


    $salleTeteDor1 = new Location();
    $salleTeteDor1->setLabel("Salle Tête d’Or 1");
    $salleTeteDor1->setCapacity(240);
    $em->persist($salleTeteDor1);


    /***** Speakers + events *******/

    //Christophe proteneuve
    $christophe_porteneuve = new Person();
    $christophe_porteneuve->setFamilyName("Porteneuve");
    $christophe_porteneuve->setFirstName("Christophe");
    $christophe_porteneuve->setDescription("Christophe Porteneuve conçoit des pages web depuis 1995. Co-créateur du premier portail JSP en Europe, en 1999, il passe par J2EE avant de tomber dans Ruby, Rails puis Node. Auteur du best-seller « Bien développer pour le Web 2.0 » chez Eyrolles, il a également écrit la référence  « Prototype and script.aculo.us » chez Pragmatic Programmers, des articles dans divers magazines en ligne, et il est speaker pour plusieurs conférences petites et grosses.");
    $christophe_porteneuve->setTwitter("porteneuve");
    $christophe_porteneuve->setWebsite("http://tddsworld.com");
    $christophe_porteneuve->setImg("http://www.blendwebmix.com/wp-content/uploads/2013/07/christophe-porteneuve-269x200.png");
    $em->persist($christophe_porteneuve);


    //Guilhem bertholet
    $guilhem_bertholet = new Person();
    $guilhem_bertholet->setFamilyName("Bertholet");
    $guilhem_bertholet->setFirstName("Guilhem");
    $guilhem_bertholet->setDescription("Saltimbanque & Entrepreneur depuis 1981 // #ContentMarketing @invoxfr // #NoeudPap @blendwebmix & @lacuisineduweb // Happy.");
    $guilhem_bertholet->setTwitter("guilhem");
    $guilhem_bertholet->setWebsite("http://www.guilhembertholet.com/blog/");
    $guilhem_bertholet->setImg("https://pbs.twimg.com/profile_images/435793447589404672/m-7_Cier_400x400.jpeg");
    $em->persist($guilhem_bertholet);


    //Damien mathieu
    $damien_mathieu = new Person();
    $damien_mathieu->setFamilyName("Mathieu");
    $damien_mathieu->setFirstName("Damien");
    $damien_mathieu->setDescription("Ingénieur logiciel polyglotte particulièrement intéressé par le web, je travaille chez Heroku, ou je fais du support technique et des outils interne. Particulièrement intéressé par la scalabilité et la stabilité, je m'intéresse beaucoup aux problèmes architecturaux de stabilité logicielle. Ancien Lyonnais, j'habite aujourd'hui Toulouse.");
    $damien_mathieu->setTwitter("Dstroii");
    $damien_mathieu->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/herve_mischler-269x200.jpg");
    $em->persist($damien_mathieu);


    //Herve mischler
    $herve_mischler = new Person();
    $herve_mischler->setFamilyName("Mischler");
    $herve_mischler->setFirstName("Hervé");
    $herve_mischler->setDescription("Hervé Mischler est Designer d’expérience utilisateur chez Salesforce.com le leader du cloud computing et du CRM. Après une formation de designer industriel, il débute dans le web en 1999. Passionné par le code et le design, son approche technique prend en compte les problématiques liées à l’expérience utilisateur.");
    $herve_mischler->setTwitter("dmathieu");
    $herve_mischler->setWebsite("http://dmathieu.com/");
    $herve_mischler->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/qYxmw_yS_400x400-269x200.png");
    $em->persist($herve_mischler);

    //Darja gartner
    $darja_gartner = new Person();
    $darja_gartner->setFamilyName("Gartner");
    $darja_gartner->setFirstName("Darja");
    $darja_gartner->setDescription("Après avoir travaillé en agence en Slovénie (son pays natal) et en freelance à Paris, Darja est maintenant Directrice Artistique de Netinfluence, une agence digitale à Lausanne. Grande sportive dans l’éternel, elle partage son temps libre entre le running, le yoga, et les différents side-projects et événements organisés avec 17slash (le studio qu’elle a fondé avec Jérémie).");
    $darja_gartner->setTwitter("gartner");
    $darja_gartner->setWebsite("http://darja.me");
    $darja_gartner->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Darja-Gatner-269x200.jpg");
    $em->persist($darja_gartner);

    //Damien gosset
    $damien_gosset = new Person();
    $damien_gosset->setFamilyName("Gosset");
    $damien_gosset->setFirstName("Damien");
    $damien_gosset->setDescription("Dirigeant une société spécialisée dans le développement d'applications mobiles et les technologies Apple, il partage aujourd'hui son temps entre son équipe et les aéroports.
Passionné de nouvelles technologies et d'innovation, il intervient en temps que formateur et conférencier auprès d'écoles et d'universités en France et à l'international (Europe, Chine, Canada, USA, Brésil…).");
    $damien_gosset->setTwitter("dgosset");
    $damien_gosset->setWebsite("http://fr.linkedin.com/in/damiengosset");
    $damien_gosset->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/damien-gosset-269x200.png");
    $em->persist($damien_gosset);

    //Benjamain clay
    $benjamin_clay = new Person();
    $benjamin_clay->setFamilyName("Clay");
    $benjamin_clay->setFirstName("Benjamin");
    $benjamin_clay->setDescription("Passionné du Web depuis plus de 15 ans et diplômé de l’EISTI, Benjamin Clay travaille depuis 2008 en tant que développeur puis expert PHP / Symfony2. Early adopter de Titanium, il se concentre pleinement sur cette technologie dès la sortie de TiAlloy qu'il affectionne particulièrement pour concocter des applications mobiles cross-platforms performantes, innovantes et pailletées.");
    $benjamin_clay->setTwitter("ternel");
    $benjamin_clay->setWebsite("http://jolicode.com");
    $benjamin_clay->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/09/ternel-11-210x200.jpg");
    $em->persist($benjamin_clay);

    //Mathieu parisot
    $mathieu_parisot = new Person();
    $mathieu_parisot->setFamilyName("Parisot");
    $mathieu_parisot->setFirstName("Mathieu");
    $mathieu_parisot->setDescription("Développeur Java et web passionné de nouvelles technologies et d’innovation, impliqué dans de nombreuses communautés et co-organisateur des HumanTalks à Paris. Après avoir fait du Java pendant de nombreuses années, Mathieu s’intéresse maintenant principalement aux problématiques web : HTML5, CSS3, Responsive Web Design, conception de sites web pour smartphones.");
    $mathieu_parisot->setTwitter("matparisot");
    $mathieu_parisot->setWebsite("http://blog.soat.fr");
    $mathieu_parisot->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Mathieu-parisot-mini-175x200.jpg");
    $em->persist($mathieu_parisot);

    //Jade le maitre
    $jade_lemaitre = new Person();
    $jade_lemaitre->setFamilyName("Le maître");
    $jade_lemaitre->setFirstName("Jade");
    $jade_lemaitre->setDescription("Einstein took science, I took curiosity... Entre science et social média, Jade Le Maître est une passionnée d'innovation et live-tweeteuse compulsive. Elle rêve d‘interfaces entre le web et les différents acteurs des sciences – laboratoires, instituts, universités, entreprises.");
    $jade_lemaitre->setTwitter("Aratta");
    $jade_lemaitre->setWebsite("http://www.jadelemaitre.fr/");
    $jade_lemaitre->setImg("http://www.blendconference.com/wp-content/uploads/2013/07/jade-lm-aratta-269x200.jpg");
    $em->persist($jade_lemaitre);

    //Goulven champenois
    $goulven_champenois = new Person();
    $goulven_champenois->setFamilyName("Champenois");
    $goulven_champenois->setFirstName("Goulven");
    $goulven_champenois->setDescription("Intégrateur passionné, Goulven Champenois jongle avec l’accessibilité, l’ergonomie, les performances et le mobile pour une expérience utilisateur optimale intégrant les dernières évolutions technologiques. Après une expérience chez Alptis en tant que développeur front-end, il se lance en freelance en 2012. Formé en grande partie grâce aux sites OpenWeb et Pompage, il rejoint ce projet en 2006.");
    $goulven_champenois->setTwitter("goulvench");
    $goulven_champenois->setWebsite("http://userland.fr/");
    $goulven_champenois->setImg("http://www.blendconference.com/wp-content/uploads/2013/07/Capture-d%E2%80%99%C3%A9cran-2013-07-12-%C3%A0-14.42.35-269x200.png");
    $em->persist($goulven_champenois);

    //Mathieu lux
    $mathieu_lux = new Person();
    $mathieu_lux->setFamilyName("Lux");
    $mathieu_lux->setFirstName("Mathieu");
    $mathieu_lux->setDescription("Développeur et formateur Java EE et Web au sein de l'agence lyonnaise de Zenika. (@Swiip & http://swiip.github.com/) Ma contribution technique à de nombreux projets Web m’a permis d'être expert à la fois dans les architectures Java EE (Spring, Hibernate, JPA ...), et le Web (HTML5, AngularJS, NodeJS, Grunt...). Passionné de JavaScript, je suis également administrateur du Lyon JS.");
    $mathieu_lux->setTwitter("Swiip");
    $mathieu_lux->setWebsite("http://swiip.github.io/");
    $mathieu_lux->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/MLUX-269x200.jpg");
    $em->persist($mathieu_lux);


    //Julien Deniau
    $julien_deniau = new Person();
    $julien_deniau->setFamilyName("Deniau");
    $julien_deniau->setFirstName("Julien");
    $julien_deniau->setDescription("Développeur, principalement sur PHP depuis 2006, j'ai passé plusieurs années en SSII, notamment pour M6Web. J'ai débuté l'aventure Mapado.com il y a un an et demi. Je passe une bonne partie de ma journée à faire du PHP, mais start-up oblige, je touche aussi à un peu de Javascript, du Python, à du management de serveur, à de l'intégration, etc.");
    $julien_deniau->setTwitter("j_deniau");
    $julien_deniau->setWebsite("http://www.mapado.com");
    $julien_deniau->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/j_deniau-269x200.jpg");
    $em->persist($julien_deniau);

    //Brice favre
    $brice_favre = new Person();
    $brice_favre->setFamilyName("Favre");
    $brice_favre->setFirstName("Brice");
    $brice_favre->setDescription("De 1998 à 2002 je débute ma carrière chez l'opérateur téléphonique A-Telecom où je poursuis mes études d'ingénieur en alternance. Par la suite je participe à plusieurs longues missions en indépendant pour divers clients, comme Cegetel. Spécialiste du PHP je rejoins la société SQLI en tant qu'Architecte orienté PHP. J'ai la charge de la création du pôle d'architecture PHP et je méne plusieurs projets autour du framework copix et du CMS Drupal.");
    $brice_favre->setTwitter("briceatwork");
    $brice_favre->setWebsite("http://pelmel.org/");
    $brice_favre->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/FAVRE_Brice_sousleau-269x200.jpg");
    $em->persist($brice_favre);


    //Jean philippe cabaroc
    $jean_philippe_cabaroc = new Person();
    $jean_philippe_cabaroc->setFamilyName("Cabaroc");
    $jean_philippe_cabaroc->setFirstName("Jean-Philippe");
    $jean_philippe_cabaroc->setDescription("Designer et directeur artistique, Jean-Philippe Cabaroc aime les designs qui racontent une histoire. Il a fondé son studio de création graphique en 2009 après avoir travaillé 5 ans en agence de communication. Spécialisé dans la conception d’identités visuelles, Cabaroc taille sur mesure l'image des entreprises pour le décliner de l'imprimé au numérique en passant par les supports vidéos.");
    $jean_philippe_cabaroc->setTwitter("cabaroc");
    $jean_philippe_cabaroc->setWebsite("http://www.cabaroc.com");
    $jean_philippe_cabaroc->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/09/Cabaroc-269x200.jpg");
    $em->persist($jean_philippe_cabaroc);


    //LAURENCE BRICTEUX
    $laurence_bricteux = new Person();
    $laurence_bricteux->setFamilyName("Bricteux");
    $laurence_bricteux->setFirstName("Laurence");
    $laurence_bricteux->setDescription("A la tête des Ateliers-Goûters du Code lancés en mars 2014, chargée de cours de stratégie digitale dans une école à Marseille, coach de startups en incubation à Kedge Business Nursery et StartupWE, représentante de Girls In Tech à Marseille, j'ai acquis mon expérience des nouvelles technologies au sein d'Apple EMEA à Paris et Londres, où j'ai été chargée pendant 10 ans (soit du 1er imac au second iPhone en langue Apple) de la communication produits, et ensuite du marketing du marché de l’Education.");
    $laurence_bricteux->setTwitter("laurence0501");
    $laurence_bricteux->setWebsite("http://www.ateliergouterducode.org");
    $laurence_bricteux->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/09/Laurence-Bricteux-269x200.jpg");
    $em->persist($laurence_bricteux);


    //SÉBASTIEN CHARRIER
    $sebastien_charrier = new Person();
    $sebastien_charrier->setFamilyName("Charrier");
    $sebastien_charrier->setFirstName("Sébastien");
    $sebastien_charrier->setDescription("Après quelques années d'études dans l'informatique, Sébastien était convaincu que développeur n'était pas un vrai boulot, qu'il lui fallait être au moins chef de projet pour réussir sa vie. Il est donc passé par des postes de consultant, chef de produit, chef de projet, directeur technique avant de revenir à ses premières amours : le développement.");
    $sebastien_charrier->setTwitter("scharrier");
    $sebastien_charrier->setWebsite("http://craftsmen.io");
    $sebastien_charrier->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/CRAFTSMEN_7715_carree-269x200.jpg");
    $em->persist($sebastien_charrier);


    //BERTRAND COCHET
    $bertrand_cochet = new Person();
    $bertrand_cochet->setFamilyName("Cochet");
    $bertrand_cochet->setFirstName("Bertrand");
    $bertrand_cochet->setDescription("Bertrand Cochet est consultant ergonome senior pour l'agence Wax Interactive (SQLI Group). Ancien directeur artistique, il s'est tourné vers la conception de dispositifs numériques en 2004 où il a déployé des méthodes expertes et collaboratives destinées à optimiser l'expérience utilisateur et l'utilisabilité des interfaces.");
    $bertrand_cochet->setTwitter("bcochet");
    $bertrand_cochet->setWebsite("http://www.fittsize-me.com");
    $bertrand_cochet->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/09/Bertrand-Cochet-269x200.jpg");
    $em->persist($bertrand_cochet);

    //BENJAMIN DURAND
    $benjamin_durand = new Person();
    $benjamin_durand->setFamilyName("Durand");
    $benjamin_durand->setFirstName("Benjamin");
    $benjamin_durand->setDescription("Mon parcours scolaire est assez classique avec un DUT Technico-commercial à l’IUT d’Annecy et un Bachelor en communication à Paris à L’Ecole Supérieure de Publicité. Mes études m'ont surtout permis de rencontrer mes premiers associés pour créer ma première société en 2008. J'ai remporté, en 2007, le concours Graines d’Entrepreneurs de la CCI Haute-Savoie qui récompensait le meilleur projet d’entreprise.");
    $benjamin_durand->setTwitter("Benjamin_Durand");
    $benjamin_durand->setWebsite("http://bealder.com/");
    $benjamin_durand->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Benjamin-DURAND-photo-269x200.jpg");
    $em->persist($benjamin_durand);


    //XAVIER BLOT
    $xavier_blot = new Person();
    $xavier_blot->setFamilyName("Blot");
    $xavier_blot->setFirstName("Xavier");
    $xavier_blot->setDescription("Ma vie a commencée par un amour immodéré pour les sciences. Après, un diplôme d’ingénieur et un master en mécanique quantique à Toulouse, j’ai enchainé sur une thèse dans le solaire photovoltaïque, à Grenoble. Je suis en train de la terminer. Entre temps, j’ai pu travailler dans des laboratoires de recherche français et étrangers puis chez des industriels du secteur.
En parallèle j’ai participé à divers projets entrepreneuriaux dont notamment un plateforme de cours particulier qui fut un échec. Fin 2013, j’ai co-fondé BeyondLab, un réseau qui met en relation les chercheurs et leurs technologies avec les entrepreneurs capables d’en faire des applications innovantes.");
    $xavier_blot->setTwitter("XavierBlot");
    $xavier_blot->setWebsite("http://www.beyondLab.com");
    $xavier_blot->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/profil-200x200.jpg");
    $em->persist($xavier_blot);


    //MARIE EKELAND
    $marie_ekeland = new Person();
    $marie_ekeland->setFamilyName("Ekeland");
    $marie_ekeland->setFirstName("Marie");
    $marie_ekeland->setDescription("Marie Ekeland est investisseur en capital-risque et co-Présidente de France Digitale. Ancienne associée chez Elaia Partners, elle a notamment investi dans les sociétés Criteo, Mobirider, Pandacraft, Seven Academy, Scoop.it, Teads, Wyplay et Ykone. Elle a débuté sa carrière en 1997 en tant qu'informaticienne au sein de la banque d’affaires JP Morgan, d’abord à New York, où elle a participé au développement d’une application destinée aux salles de marché Fixed Income, puis à Paris, où elle a géré l’équipe en charge de son support global. Elle rejoint le capital-risque en intégrant l'équipe d'investissement de CPR Private Equity (groupe Crédit Agricole) en 2000.");
    $marie_ekeland->setTwitter("bibicheri");
    $marie_ekeland->setWebsite("http://www.francedigitale.org/");
    $marie_ekeland->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Marie-Ekeland1-269x200.jpg");
    $em->persist($marie_ekeland);


    //FRANCK VERROT
    $franck_verrot = new Person();
    $franck_verrot->setFamilyName("Verrot");
    $franck_verrot->setFirstName("Franck");
    $franck_verrot->setDescription("Franck est Product Owner et plus généralement ingénieur logiciel chez Worldline. Son intérêt pour la qualité logicielle se traduit autant par la pratique du TDD que du BDD, sujet qui lui tient à coeur depuis plusieurs années déjà, notamment au travers des approches « Executable Specifications » ou « Specification by Example ».");
    $franck_verrot->setTwitter("franckverrot");
    $franck_verrot->setWebsite("http://github.com/franckverrot");
    $franck_verrot->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/09/Franck-Verrot-269x200.jpg");
    $em->persist($franck_verrot);


    //CHRISTOPHE GAGIN
    $christophe_gagin = new Person();
    $christophe_gagin->setFamilyName("Gagin");
    $christophe_gagin->setFirstName("Christophe");
    $christophe_gagin->setDescription("Je suis co-fondateur d'Azendoo.com, une application cloud qui offre une nouvelle expérience de travail collaboratif et s’intègre avec Evernote, Box, Dropbox et Google Drive. Deux ans après son lancement, Azendoo compte plus de 250.000 utilisateurs partout dans le monde. J'ai 15 ans d'expérience en Software Design, Product Management, Product Marketing, User eXperience Design, Customer Satisfaction et les ventes complexes de logiciels aux entreprises.");
    $christophe_gagin->setTwitter("chrisgagin");
    $christophe_gagin->setWebsite("http://www.azendoo.com");
    $christophe_gagin->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/09/Christophe-Gagin.jpeg");
    $em->persist($christophe_gagin);


    //JEROME MASUREL
    $jerome_mazurel = new Person();
    $jerome_mazurel->setFamilyName("Mazurel");
    $jerome_mazurel->setFirstName("Jérôme");
    $jerome_mazurel->setDescription("Jérôme Masurel commence sa carrière dans la capital-risque à New York chez NextStage, puis chez Rotschild &Cie Private Equity à Paris. Il participe au lancement du réseau Agregator qui a donné naissance au site Viadeo. En 2010 il fonde Investir en Direct pour aider les projets en amorçage à trouver des fonds auprès d’un réseau de dirigeants d’entreprises. Investir en Direct accompagne chaque année une quinzaine de levées de fonds entre 500K€ et 1M€.");
    $jerome_mazurel->setTwitter("50partners");
    $jerome_mazurel->setWebsite("http://www.50partners.fr");
    $jerome_mazurel->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/J%C3%A9r%C3%B4me-Masurel-269x200.png");
    $em->persist($jerome_mazurel);


    //GOEFFREY DORNE
    $geoffrey_dorne = new Person();
    $geoffrey_dorne->setFamilyName("Dorne");
    $geoffrey_dorne->setFirstName("Geoffrey");
    $geoffrey_dorne->setDescription("Geoffrey Dorne est designer et a créé Design & Human. Diplômé de l’Ensad, il travaille pour la culture, la société et l'humain avec la Croix Rouge, la CNIL, la fondation Mozilla, la fondation Wikimedia, le Commissariat à l’Énergie Atomique, la recherche contre le sida, EDF, Samsung, Orange...");
    $geoffrey_dorne->setTwitter("GeoffreyDorne");
    $geoffrey_dorne->setWebsite("http://GeoffreyDorne.com");
    $geoffrey_dorne->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Geoffrey_Dorne-269x200.jpg");
    $em->persist($geoffrey_dorne);


    //ALAIN REGNIER
    $alain_regnier = new Person();
    $alain_regnier->setFamilyName("Regnier");
    $alain_regnier->setFirstName("Alain");
    $alain_regnier->setDescription("CTO d'Alto Labs, architecte Technique et Entrepreneur passionné d'innovation et ayant passé 10 ans dans la Silicon Valley. Spécialiste français des Google Glass. #GlassExplorer.");
    $alain_regnier->setTwitter("altolabs");
    $alain_regnier->setWebsite("http://fr.linkedin.com/in/alainregnier/");
    $alain_regnier->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Alain-Regnier-225x200.jpeg");
    $em->persist($alain_regnier);


    //OLIVIA LOR
    $olivia_lor = new Person();
    $olivia_lor->setFamilyName("Lor");
    $olivia_lor->setFirstName("Olivia");
    $olivia_lor->setDescription("Après des études d'arts appliqués et des débuts dans le webdesign, Olivia s'est orientée vers l'UX lors de son master (MICNI) à l'école Gobelins. Aujourd’hui en poste chez Ekino (filiale technique du groupe Fullsix), elle a l’occasion de côtoyer au quotidien les problématiques techniques liées au développement d’interfaces digitales, en complément des problématiques d’expérience utilisateur. Elle travaille beaucoup sur des projets en responsive design pour des grands comptes et utilise à outrance le #Bisou.");
    $olivia_lor->setTwitter("altolabs");
    $olivia_lor->setWebsite("http://fr.linkedin.com/in/olivialor/");
    $olivia_lor->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Olivia-Lor-269x200.jpg");
    $em->persist($olivia_lor);


    //FRANCIS CHOUQUET
    $francis_chouquet = new Person();
    $francis_chouquet->setFamilyName("Chouquet");
    $francis_chouquet->setFirstName("Francis");
    $francis_chouquet->setDescription("Graphiste depuis dix ans, j’ai toujours été très intéressé par la typographie. Ayant un bagage de dessin et de peinture, je me suis rapidement mis à crayonner des lettres et à entrer dans le grand monde du dessin de caractères. Passionné à la fois par l’époque victorienne comme par le sign painting, j’ai décidé il y a quelques années de prendre cette activité au sérieux et d’en faire une flèche supplémentaire à mon arc");
    $francis_chouquet->setTwitter("Fran6");
    $francis_chouquet->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Francis-Chouquet-225x200.jpeg");
    $em->persist($francis_chouquet);


    //NICOLAS COHEN
    $nicolas_cohen = new Person();
    $nicolas_cohen->setFamilyName("Cohen");
    $nicolas_cohen->setFirstName("Nicolas");
    $nicolas_cohen->setDescription("En 2007, Nicolas Cohen et Nicolas d’Audiffret, deux amis attirés par l’entrepreneuriat et à la recherche de projets porteurs de sens, rencontrent par hasard Igor, un artisan du Sud-Ouest de la France qui travaille la vaisselle en ardoise. En discutant avec lui, ils prennent conscience que les petits artisans et créateurs ont une problématique majeure : s’ils aiment créer, ils ne savent pas toujours mettre en valeur et vendre leur travail.");
    $nicolas_cohen->setTwitter("nicolascoh");
    $nicolas_cohen->setWebsite("http://www.alittlemarket.com/");
    $nicolas_cohen->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/07/Nicolas-Cohen-copyright-Silvere-Leprovost-269x200.jpg");
    $em->persist($nicolas_cohen);


    //HENRI LEPIC
    $henri_lepic = new Person();
    $henri_lepic->setFamilyName("Lepic");
    $henri_lepic->setFirstName("Henri");
    $henri_lepic->setDescription("Henri Lepic, IT addict. Au démarrage du grand succès d'internet en 1999, il part vivre à Berkeley en Californie où il découvre une toute nouvelle culture. A son retour en France, il décide de prendre des cours de design. Après un master web en poche, il se tourne vers ses fondamentaux : la création de sites web, ce qui l'amène à créer Kong Interactive une agence créative située à Paris 10°. Il est rapidement amené à gérer des comptes clients exigeants tels que France Télévision Publicité ou Volkswagen ce qui le pousse vers une culture du software craftsmanship (artisanat logiciel).");
    $henri_lepic->setTwitter("henripic");
    $henri_lepic->setWebsite("");
    $henri_lepic->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Henri-Lepic-269x200.png");
    $em->persist($henri_lepic);


    //FRANCOIS LE PICHON
    $francois_le_pichon = new Person();
    $francois_le_pichon->setFamilyName("Le Pichon");
    $francois_le_pichon->setFirstName("François");
    $francois_le_pichon->setDescription("Diplomé en arts plastiques en 2002, François se passionne rapidement pour le web et son écosystème. Directeur artistique, il se forge également de solides connaissances en ergonomie, expérience utilisateur et développement web. Après différentes expériences en agences et start-ups, il fonde Steaw en 2008, studio de digital basé à Paris.");
    $francois_le_pichon->setTwitter("iamstark");
    $francois_le_pichon->setWebsite("http://www.steaw.com");
    $francois_le_pichon->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/Henri-Lepic-269x200.png");
    $em->persist($francois_le_pichon);


    //MAXIME PRADES
    $maxime_prades = new Person();
    $maxime_prades->setFamilyName("Prades");
    $maxime_prades->setFirstName("Maxime");
    $maxime_prades->setDescription("Maxime Prades est Platform Product Manager chez Zendesk, plateforme de gestion de la relation client en ligne. Après plus de 6 ans passés en Chine et une école de commerce à Paris, Maxime débute sa carrière chez Novapost/People Doc, leader de la dématérialisation des documents RH. Piqué par le fameux virus du web et étant lui même pilote privé, il démarre avec deux amis Cloudy.fr une startup de logiciels pour pilotes privés et professionnels qu'ils revendent 2 ans plus tard.");
    $maxime_prades->setTwitter("prades_maxime");
    $maxime_prades->setWebsite("http://about.me/maximeprades");
    $maxime_prades->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/07/Maxime_prades-269x200.jpg");
    $em->persist($maxime_prades);


    //OLIVIER COMBE
    $olivier_combe = new Person();
    $olivier_combe->setFamilyName("Combe");
    $olivier_combe->setFirstName("Olivier");
    $olivier_combe->setDescription("Développeur web autodidacte, Olivier Combe adore tout ce qui touche au front-end et tout particulièrement le Javascript et le CSS. Consultant chez Peaks depuis 3 ans, il a fait ses armes chez M6Web et Kreactive où il s'est pris de passion pour AngularJS.");
    $olivier_combe->setTwitter("OCombe");
    $olivier_combe->setWebsite("https://www.linkedin.com/in/oliviercombe");
    $olivier_combe->setImg("http://www.blendwebmix.com/wp-content/uploads/2014/10/olivier-combe-269x200.jpg");
    $em->persist($olivier_combe);
  }
}
