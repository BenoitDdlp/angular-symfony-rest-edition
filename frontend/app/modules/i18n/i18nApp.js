'use strict';

/**
 * i18n App Module
 * Responsible for all translations and the changeLang event management
 * @type {module}
 */
var i18nApp = angular.module('i18nApp', ['pascalprecht.translate']);

/**
 * Configuring $translateProvider
 */
i18nApp.config(['$translateProvider', function ($translateProvider)
{


    //Intialization of the translate provider
    $translateProvider.preferredLanguage('en');


    //Register translation table as object hash for US language
    $translateProvider.translations('en_US', {

        //Global
        global: {
            actions    : {
                go_home          : 'Go back to home',
                actions          : 'Actions',
                lang             : 'Language',
                save             : 'Save',
                ok               : 'Ok',
                cancel           : 'Cancel',
                details          : 'View details &raquo;',
                show             : 'Show',
                edit             : 'Edit',
                search           : 'Search',
                placeHolderSearch: 'Search...'
            },
            labels     : {
                or    : 'Or',
                on    : 'on',
                at    : 'at',
                day   : 'day',
                days  : 'Days',
                to    : 'To',
                from  : 'From',
                as_a: 'as a',
                see_more : 'See more ...',
                search: {
                    displaying: 'Displaying results for',
                    no_result: 'No results found',
                    results  : 'Results'
                },
                list  : 'List',
                http  : 'http://...',
                undefined  : 'Not defined'

            },
            validations: {
                error              : 'Error',
                success            : 'Success',
                modifications_saved: 'Modifications saved'

            },
            constants  : {
                editable_field: 'Click here to edit this field'
            }
        },


        navleft       : {
            home             : 'Home',
            overview         : 'Overview',
            analytics        : 'Analytics',
            informations     : 'Informations',
            settings         : 'Settings',
            appearance       : 'Appearance',
            directory        : 'Directory',
            community        : 'Community',
            powered_by       : 'Powered by asre.com',
            help             : 'Help',
            infos            : 'Infos',
            import           : 'Import',
            resource         : 'Resouces',
            highlights       : 'Highlights',
            embedded_calendar: 'Embedded calendar',
            ticket_page      : 'Ticket page',
            mobile_app       : 'Mobile app',
            widgets          : 'Widgets',
            slides           : 'Slides'
        },


        //Authentication
        authentication: {
            actions    : {
                signin : 'Sign In',
                signup : 'Sign Up',
                signout: 'Sign Out'
            },
            validations: {
                signin_success          : 'Welcome to Asre',
                signin_error            : 'Bad credentials',
                signout_success         : 'Thanks for coming, see you soon',
                signup_success          : 'Thanks for registering, You will receive an email to complete your registration',
                signup_error            : 'We couldn\'t sign you up. Please contact our support service.',
                signup_confirm          : 'You account is now activated.',
                signup_email_in_use     : 'Email already in use.',
                signup_username_in_use  : 'Username already in use.',
                signup_confirm_error    : 'Invalid confirmation token.',
                change_pwd_success      : 'Your password has been changed',
                change_pwd_error        : 'Sorry, we couldn\'t change your password',
                reset_pwd_request_sended: 'The email that will allow you to change your password has been sended',
                reset_pwd_usernotfound  : 'The user has not been found.',
                reset_pwd_alreadyrequested: 'Password reset has already been requested.',
                reset_pwd_resetexpired  : 'The Password reset request has expired',
                pwd_too_short           : 'Your password is required to be at least 3 characters',
                pwd_too_long            : 'Your password cannot be longer than 20 characters',
                pwd_not_enough_strength : 'Your password must contains 2 Uppercase Letters, 1 Special Caracteres as !@#$&*,2 digits,3 Lowercase letters, 0 space',
                pwd_not_match           : 'Passwords must match',
                username_too_short      : 'Your username is required to be at least 5 characters',
                username_too_long       : 'Your username cannot be longer than 128 characters',
                username_with_whitespace: 'Your username cannot contain white spaces'

            },
            messages   : {
                signin_required             : 'This action needs you to be connected.',
                reset_pwd_info              : 'To reset your password, enter the email address you use to sign in to Asre. You will receive an email from Asre with the link to use in order to reset your password',
                pwd_not_set                 : 'You haven\'t set your password yet',
                forbidden                   : 'You don\'t have the authorization to perform this action',
                cannot_demote_youself       : 'You cannot demote yourself.',
                cannot_add_owner_as_teammate: 'You cannot add the owner as teammate.'
            },
            links      : {
                authentication: 'Authentication'
            },
            labels     : {
                username            : 'Username',
                username_create     : 'Choose your username',
                password            : 'Password',
                email               : 'Your email address',
                profile             : 'My profile',
                forgotten_pwd       : 'Forgotten password ?',
                remember_me         : 'Remember me ',
                signup_title        : 'Sign Up',
                signup_button       : 'Sign Up',
                create_pwd          : 'Create a password',
                current_pwd         : 'Current password',
                change_pwd          : 'Change my password',
                new_pwd             : 'New password',
                pwd_check           : 'Confirm your password',
                reset_pwd           : 'Reset my password',
                pwd_verification    : 'Verification',
                enrich_with         : 'Enrich profile with ',
                enrich_profile      : 'Enrich your profile ',
              signin_with: '',
                signin_get_started  : 'Sign In to get started or ',
                account             : 'Account settings',
                agreement           : 'User Agreement',
                agreement_acceptance: 'I accept the ',
                username_or_email   : 'Username or email',
                settings            : 'Other parameters'

            }
        },

        //topics
        topics        : {
            actions    : {
                search: 'Search a topic',
                new   : 'New topic',
                add   : 'Add a topic',
                edit  : 'Edit the topic',
                import: 'Import topics',
                export: 'Export topics',
                print : 'Print topics'
            },
            links      : {
                topics: 'Topics',
                topic : 'Topic'
            },
            labels     : {},
            validations: {
                'created'    : 'The topic has been saved',
                'not_created': 'Sorry, the topic has not been saved'
            },
            messages   : {
                delete_confirm: 'Are you sure you want to delete this topic ?'

            },
            model      : {
                label: 'Label'
            }
        },

        //locations
        locations     : {
            actions    : {
                search: 'Search a location',
                new  : 'New location',
                add  : 'Add a location',
                edit : 'Edit the location',
                import: 'Import location',
                export: 'Export location',
                print: 'Print location'
            },
            links      : {
                locations: 'Locations',
                location: 'Location'
            },
            validations: {
                'created'    : 'The location has been saved',
                'not_created': 'Sorry, the location has not been saved',
                deletion_success: 'Location deleted',
                deletion_error  : 'Sorry, we could delete this location'
            },
            messages   : {
                delete_confirm: 'Are you sure you want to delete this location ?'

            },
            model      : {
                label      : 'Label',
                description: 'Description',
                capacity   : 'Capacity',
                accessibility: 'Accessibility',
                latitude   : 'Latitude',
                longitude  : 'Longitude'
            }
        },


        //organizations
        organizations : {
            actions    : {
                search: 'Search an organization',
                new  : 'New organization',
                add  : 'Add an organization',
                edit : 'Edit the organization',
                import: 'Import organization',
                export: 'Export organization',
                print: 'Print organization'
            },
            links      : {
                organizations: 'Organizations',
                organization : 'Organization'
            },
            labels     : {
                member: 'Members'
            },
            validations: {
                'created': 'The organization has been saved',
                'not_created': 'Sorry, the organization has not been saved'
            },
            messages   : {
                delete_confirm: 'Are you sure you want to delete this organization ?',
                no_description: 'This organization has no description yet'
            },
            model      : {
                label      : 'Label',
                localization: 'localization',
                country    : 'Country',
                city       : 'City',
                website    : 'Website',
                img        : 'Image',
                description: 'Description',
                email      : 'Email'
            }
        },

        //person
        persons       : {
            actions    : {
                search      : 'Search a person',
                new         : 'New person',
                add         : 'Add a person',
                edit        : 'Edit the person',
                import      : 'Import person',
                export      : 'Export person',
                print       : 'Print person',
                edit_account: 'Edit account',
                edit_profile: 'Edit profile',
                view_profile  : 'View my profile',
                add_picture   : 'Add a picture',
                choose_picture: 'Choose a picture'

            },
            links      : {
                persons     : 'Persons',
                person      : 'Person',
                my_events   : 'My events',
                my_bookmarks: 'My bookmarks',
                my_tickets  : 'My tickets',
                my_recommandations: 'My recommandations'
            },
            labels     : {
                contact: 'Contact',
                social: 'Social accounts',
                about : 'About'
            },
            validations: {
                'created': 'The person has been saved',
                'not_created': 'Sorry, the person has not been saved'
            },
            messages   : {
                delete_confirm: 'Are you sure you want to delete this person ?',
                no_description: 'This person has no description yet'
            },
            model      : {
                label       : 'Label',
                positions: 'Positions',
                website     : 'Website',
                localization: 'Localization',
                country     : 'Country',
                city        : 'City',
                description : 'Description',
                firstname   : 'First name',
                familyname  : 'Family name',
                email       : 'Email',
                img         : 'Image',
                twitter     : 'Twitter',
                share       : 'Share'
            }
        },

        import: {
            import    : 'Import',
            validating: 'The server is validating datas... This may take a while.',
            select_file    : 'Select the csv file to import.',
            download_sample: 'Download a sample file.',
            send_to_server : 'Send to server.',
            processing     : 'The server is processing datas... This may take a while.'
        }

    });

    //Register translation table as object hash for FR language
    $translateProvider.translations('fr_FR', {
        //Global
        global: {
            actions    : {
                go_home: 'Retour à l\'accueil',
                actions: 'Actions',
                lang  : 'Language',
                save  : 'Enregistrer',
                ok    : 'Ok',
                cancel: 'Annuler',
                details: 'Détails &raquo;',
                show  : 'Voir',
                edit  : 'Modifier',

                search: 'Rechercher',
                placeHolderSearch: 'Rechercher...'
            },
            labels     : {
                or    : 'Ou',
                at    : 'à',
                from  : 'De',
                to    : 'Jusq\'à',
                as_a: 'en tant que',
                day   : 'jour',
                days  : 'Jours',
                see_more : 'Voir plus ...',
                searchResult: 'Résultat pour',
                search: {
                    displaying: 'Résultat pour',
                    no_result: 'Aucun résultat trouvé.',
                    results  : 'Résultats'
                },
                on    : 'le',
                list  : 'Liste',
                undefined  : 'Non defini'


            },
            validations: {
                error              : 'Erreur',
                success            : 'Success',
                modifications_saved: 'Modifications sauvegardées'
            },
            constants  : {
                editable_field       : 'Cliquez ici pour éditer ce champ'
            }
        },


        navleft       : {
            home        : 'Accueil',
            overview    : 'Aperçu',
            analytics   : 'Analytics',
            informations: 'Informations',
            settings    : 'Parametres',
            appearance  : 'Apparence',
            directory   : 'Participants',
            community   : 'Communauté',
            powered_by  : 'Propulsé par asre.com',
            help        : 'Aide',
            infos       : 'Information',
            import      : 'Import',
            resource    : 'Ressouces',
            highlights  : 'Live wall',
            embedded_calendar: 'Planning embarqué',
            ticket_page : 'Page tickets',
            mobile_app  : 'Application mobile',
            widgets     : 'Widgets',
            slides      : 'Slides'
        },


        //Authentication
        authentication: {
            actions    : {
                signin: 'Connexion',
                signup: 'créer votre compte',
                signout: 'Déconnexion'
            },
            validations: {
                signin_success          : 'Bienvenu sur Asre!',
                signin_error            : 'Accès refusé',
                signout_success         : 'Merci d\'utiliser Asre, à bientôt',
                signup_success          : 'Bienvenue sur Asre, vous allez recevoir un email pour terminer votre inscription',
                signup_error            : 'Désolé nous n\'avons pas pu vous connecter',
                signup_confirm          : 'Votre compte est désormais actif.',
                signup_email_in_use     : 'Email déjà utilisé.',
                signup_username_in_use  : 'nom d\'utilisateur déjà utilisé.',
                signup_confirm_error    : 'Token de confirmation non valide.',
                change_pwd_success      : 'Votre mot de passe a été modifié',
                change_pwd_error        : 'Désolé, nous n\'avons pas pu changer votre mot de passe',
                reset_pwd_request_sended: 'Un email vous permettant de mettre à jour votre mot de passe vous a été envoyé',
                reset_pwd_usernotfound  : 'Utilisateur non trouvé.',
                reset_pwd_alreadyrequested: 'La requête de changement de mot de passe a déjà été effectuée.',
                reset_pwd_resetexpired  : 'La requête de changement de mot de passe à expirée',
                pwd_too_short           : 'Votre mot de passe est trop court',
                pwd_too_long            : 'Votre mot de passe est trop long',
                pwd_not_enough_strength : 'Le mot de passe doit contenir au moins 2 caractéres en majuscule, 1 caractére special comme !@#$&*,2 chiffres,3 caractéres minuscules, 0 espace',
                pwd_not_match           : 'Les deux mots de passe doivent être identiques',
                username_too_short      : 'Votre nom d\'utilisateur est trop court',
                username_too_long       : 'Votre nom d\'utilisateur est trop long',
                username_with_whitespace: 'Votre nom d\'utilisateur ne doit pas contenir d\'espace'
            },
            messages   : {
                signin_required: 'Cette action nécessite d\'être connecté.',
                reset_pwd_info              : 'Pour reinitialiser votre mot de passe, entrer votre email ou nom d\'utilisateur. Vous recevrez alors un email pour mettre à jour votre mot de passe',
                pwd_not_set                 : 'Vous n\'avez pas encore défini votre mot de passe',
                forbidden                   : 'Vous n\'avez pas le droit d\'exécuter cette action',
                cannot_demote_youself       : 'Vous ne pouvez pas vous désinscrire vous même.',
                cannot_add_owner_as_teammate: 'Vous ne pouvez pas ajouter le créateur de l\'évènement en tant qu\'équipier.'
            },
            links      : {
                authentication: 'Authentification'
            },
            labels     : {
                username          : 'Nom d\'utilisateur',
                username_create   : 'Choisissez votre nom d\'utilisateur',
                password          : 'Mot de passe',
                email             : 'Votre adresse e-mail',
                profile           : 'Mon profil',
                forgotten_pwd     : 'Mot de passe oublié ?',
                remember_me       : 'Se souvenir de moi ',
                signup_title      : 'Créer votre compte',
                signup_button     : 'Créer mon compte',
                create_pwd        : 'Créez un mot de passe',
                current_pwd       : 'Votre mot de passe',
                change_pwd        : 'Changer mon mot de passe',
                new_pwd           : 'Nouveau mot de passe',
                pwd_check         : 'Confirmez votre mot de passe',
                reset_pwd         : 'Reinitialiser mon mot de passe',
                pwd_verification  : 'Vérification',
                enrich_with       : 'Enrichir mon profile avec',
                enrich_profile    : 'Enrichir mon profile avec',
              signin_with: '',
                signin_get_started: 'Se connecter ou ',
                account           : 'Paramètres du compte',
                agreement         : 'termes et conditions d\'utilisation',
                agreement_acceptance: 'J\'accepte les ',
                username_or_email : 'Nom d\'utilisateur ou email',
                settings          : 'Autres paramètres'
            }
        },

        //topics
        topics        : {
            actions    : {
                search: 'Rechercher un tag',
                new  : 'Nouveau tag',
                add  : 'Ajouter un tag',
                edit : 'Editer le tag',
                import: 'Importer tags',
                export: 'Exporter tags',
                print: 'Imprimer tags'
            },
            links      : {
                topics: 'Tags',
                topic: 'Tag'
            },
            labels     : {},
            validations: {
                'created': 'Le tag a été enregistré',
                'not_created': 'Désolé, Le tag n\'a pas été sauvegardé'
            },
            messages   : {
                delete_confirm: 'Etes-vous sur de vouloir supprimer ce tag ?'
            },
            model      : {
                label: 'Label'
            }
        },

        //locations
        locations     : {
            actions    : {
                search: 'Rechercher une localisation',
                new  : 'Nouvelle localisation',
                add  : 'ajouter une localisation',
                edit : 'Editer la localisation',
                import: 'Importer localisations',
                export: 'Exporter localisations',
                print: 'Imprimer localisations'
            },
            links      : {
                locations: 'Locations',
                location : 'Location'
            },
            validations: {
                'created'    : 'La localisation a été enregistré',
                'not_created': 'Désolé, la localisation n\'a pas été sauvegardée',
                deletion_success: 'Location supprimée',
                deletion_error  : 'Désolé, nous n\'avons pas pu supprimer cette location'
            },
            messages   : {
                delete_confirm: 'Etes-vous sur de vouloir supprimer cette localisation ?'
            },
            model      : {
                label      : 'Label',
                description: 'Description',
                capacity   : 'Capacité',
                accessibility: 'Accessibilité',
                latitude   : 'Latitude',
                longitude  : 'Longitude'
            }
        },

        //organizations
        organizations : {
            actions    : {
                search: 'Rechercher une organisation',
                new  : 'Nouvelle organisation',
                add  : 'Ajouter une organisation',
                edit : 'Editer l\'organisation',
                import: 'Importer organisations',
                export: 'Exporter organisations',
                print: 'Imprimer organisations'
            },
            links      : {
                organizations: 'Organisations',
                organization : 'Organisation'

            },
            labels     : {
                member: 'Membres'
            },
            validations: {
                'created': 'L\'organization a été enregistrée',
                'not_created': 'Désolé, l\'organization n\'a pas été sauvegardée'
            },
            messages   : {
                delete_confirm: 'Etes-vous sur de vouloir supprimer cette organisation ?',
                no_description: 'Cette organization n\'a pas de description pour le moment'

            },
            model      : {
                label      : 'Label',
                localization: 'localization',
                country    : 'Pays',
                city       : 'Ville',
                website    : 'Site web',
                img        : 'Image',
                description: 'Description',
                email      : 'Email'
            }
        },

        //person
        persons       : {
            actions    : {
                search      : 'Rechercher une personne',
                new         : 'Nouvelle personne',
                add         : 'Ajouter une personne',
                edit        : 'Editer la personne',
                import      : 'Importer personnes',
                export      : 'Exporter personnes',
                print       : 'Imprimer personnes',
                edit_account: 'Modifier mon compte',
                edit_profile: 'Editer mon profile',
                view_profile  : 'voir mon profile',
                add_picture   : 'Ajouter une photo',
                choose_picture: 'Choisir une photo'
            },
            links      : {
                persons     : 'Personnes',
                person      : 'Personne',
                my_events   : 'Mes évènements',
                my_bookmarks: 'Mes marques page',
                my_tickets  : 'Mes tickets',
                my_recommandations: 'Mes recommandations'
            },
            labels     : {
                contact: 'Contact',
                social: 'Réseaux sociaux',
                profil: 'Profil',

                about: 'A propos'

            },
            validations: {
                'created': 'La personne a été enregistrée',
                'not_created': 'Désolé, La personne n\'a pas été sauvegardée'
            },
            messages   : {
                delete_confirm: 'Etes-vous sur de vouloir supprimer cette personne ?',
                no_description: 'Aucune description disponible pour le moment'

            },
            model      : {
                label       : 'Label',
                localization: 'Localisation',
                positions: 'Positions',
                website     : 'Site web',
                country     : 'Pays',
                city        : 'Ville',
                description : 'Description',
                firstname   : 'Prénom',
                familyname  : 'Nom',
                email       : 'Email',
                img         : 'Image',
                twitter     : 'Twitter',
                share       : 'Partager'
            }
        },

        import: {
            import    : 'Importer',
            validating: 'Le serveur valide les données... Cela peut prendre un moment.',
            select_file    : 'Sélectionnez le fichier csv à importer.',
            download_sample: 'Téléchargez un fichier d\'éxample.',
            send_to_server : 'Envoyer au server.',
            processing     : 'Le serveur traite les données... Cela peut prendre un moment.'
        }
    });

}]);

