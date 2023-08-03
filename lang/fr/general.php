<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'yes' => 'Oui',
    'no' => 'Non',
    'welcome' => 'Bienvenue',
    'settings' => 'Paramètres',
    'upload_error' => "Une erreur s'est l'ors du stockage du fichier",
    'permission_denied' => "Vous n'êtes pas autorisé à effectué cette action",
    'square_image_recommendation' => 'Extensions autorisées JPG et PNG. Taille maximale 1Mo. Image carré',
    'portrait_image_recommendation' => 'Extensions autorisées JPG et PNG. Taille maximale 1Mo. Image en portrait',
    'landscape_image_recommendation' => 'Extensions autorisées JPG et PNG. Taille maximale 1Mo. Image en paysage',
    'no_records' => "Pas de données",
    'change_status' => "Changer le status",
    'change_status_question' => "Voulez-vous vraiment :action :name",
    'enable_toggle' => ':name désactivé avec succès',
    'disable_toggle' => ':name activé avec succès',
    'default_address' => 'Adresse par défaut',
    'billing_address' => 'Adresse de facturation',
    'shipping_address' => 'Adresse de livraison',

    'action' => [
        'detail' => 'Détails',
        'update' => 'Modifier',
        'enable' => 'Activer',
        'disable' => 'Désactiver',
        'create' => 'Créer',
        'auth' => 'Authentifier',
        'delete' => 'Supprimer',
        'other' => 'Autre',
        'update_address' => 'Modifier adresse',
        'add_shop' => 'Ajouter une boutique',
        'add_vendor' => 'Ajouter un fournisseur',
        'add_merchant' => 'Ajouter un marchand',
        'add_state' => 'Ajouter une région',
        'add_country' => 'Ajouter un pays',
        'add_coupon' => 'Ajouter un coupon',
        'add_product' => 'Ajouter un produit',
        'add_category' => 'Ajouter une catégorie',
        'add_group' => 'Ajouter un groupe',
        'add_organisation' => 'Ajouter un magasin',
        'add_attribute_value' => 'Ajouter une valeur',
        'add_attribute' => 'Ajouter un attribut',
    ],

    'role' => [
        'customer' => 'Client',
        'seller' => 'Vendeur',
        'admin' => 'Admin',
        'merchant' => 'Marchand',
        'shop_manager' => 'Gestionnaire',
        'super_admin' => 'Super admin',
    ],

    'type' => [
        'text' => "Texte",
        'select' => "Sélection",
        'color' => "Couleur",
    ],

    'status' => [
        'enable' => "Actif",
        'active' => "Actif",
        'blocked' => "Bloqué",
        'stand_ty' => "En attente",
        'disable' => "Inactif",
        'unknown' => "Inconnu",
    ],

    'media' => [
        'images' => "Images",
        'flags' => "Drapeaux",
        'avatars' => "Avatars",
        'banners' => "Bannières",
        'logos' => "Logos",
        'videos' => "Videos",
        'documents' => "Documents",
        'delete' => "Supprimer ce média",
        'delete_question' => 'Voulez-vous vraiment supprimer ce média',
        'deleted' => 'Média supprimé avec succès',
        'clear_garbage' => 'Nettoyer les fichiers inutilisés',
        'clear_garbage_question' => 'Voulez-vous vraiment nettoyer les fichiers inutilisés',
        'garbage_cleared' => 'Fichiers inutilisés nettoyés avec succès',
    ],

    'login' => [
        'enter_your_credentials' => 'Entrez vos identifiants',
        'forgotten_password' => 'Mot de passe oublié',
        'remember_me' => 'Se rappeler de moi',
        'new_on_this_platform' => 'Nouveau sur cette plateforme',
        'create_an_account' => 'Créer un compte',
        'invalid_credentials' => 'Identifiants incorrect',
        'welcome_name' => 'Bienvenue :name',
    ],

    'profile' => [
        'general' => 'Général',
        'logs' => 'Journaux',
        'settings' => 'Paramètres',
        'password' => 'Mot de passe',
        'avatar' => 'Avatar',
        'address' => 'Address',
        'delete_avatar_question' => 'Voulez-vous vraiment supprimer votre avatar',
        'delete_avatar' => 'Supprimer mon avatar',
        'notifications' => 'Notifications',
        'profile_updated' => 'Profil mis à jour avec succès',
        'profile_default_address_updated' => 'Adresse par défaut mise à jour avec succès',
        'profile_default_address_created' => 'Adresse par défaut ajoutée avec succès',
        'profile_avatar_updated' => 'Avatar mis à jour avec succès',
        'profile_avatar_created' => 'Avatar ajouté avec succès',
        'profile_avatar_deleted' => 'Avatar supprimé avec succès',
        'password_updated' => 'Mot de passe mis à jour avec succès',
        'settings_updated' => 'Paramètres mis à jour avec succès',
        'incorrect_old_password' => 'Ancien mot de passe incorrect',
        'identical_passwords' => "Mot de passes identiques, merci de donner un nouveau mot de passe différent de l'ancien mot de passe ",
    ],

    'organisation' => [
        'created' => 'Magasin :name créer',
        'updated' => 'Magasin :name mis à jour',
        'logo_deleted' => 'Logo du magasin :name supprimé avec succès',
        'logo_created' => 'Logo du magasin :name ajouté avec succès',
        'logo_updated' => 'Logo du magasin :name mis à jour avec succès',
        'delete_logo_question' => 'Voulez-vous vraiment supprimer le logo de ce magasin',
        'delete_logo' => 'Supprimer le logo du magasin',
        'banner_deleted' => 'Bannière du magasin :name supprimée avec succès',
        'banner_created' => 'Bannière du magasin :name ajoutée avec succès',
        'banner_updated' => 'Bannière du magasin :name mise à jour avec succès',
        'delete_banner_question' => 'Voulez-vous vraiment supprimer la bannière de ce magasin',
        'delete_banner' => 'Supprimer la bannière du magasin',
    ],

    'shop' => [
        'created' => 'Boutique :name créer',
        'updated' => 'Boutique :name mise à jour',
        'shop_default_address_updated' => 'Adresse par défaut mise à jour avec succès',
        'shop_default_address_created' => 'Adresse par défaut ajoutée avec succès',
    ],

    'country' => [
        'created' => 'Pays :name créer',
        'updated' => 'Pays :name mis à jour',
        'flag_deleted' => 'Drapeau du pays :name supprimé avec succès',
        'flag_created' => 'Drapeau du pays :name ajouté avec succès',
        'flag_updated' => 'Drapeau du pays :name mis à jour avec succès',
        'delete_flag_question' => 'Voulez-vous vraiment supprimer le drapeau de ce pays',
        'delete_flag' => 'Supprimer le drapeau du pays',
    ],

    'customer' => [
        'created' => 'Client :name créer',
    ],

    'brand' => [
        'created' => 'Marque :name créer',
        'updated' => 'Marque :name mise à jour',
        'logo_deleted' => 'Logo de la marque :name supprimé avec succès',
        'logo_created' => 'Logo de la marque :name ajouté avec succès',
        'logo_updated' => 'Logo de la marque :name mis à jour avec succès',
        'delete_logo_question' => 'Voulez-vous vraiment supprimer le logo de cette marque',
        'delete_logo' => 'Supprimer le logo de la marque',
    ],

    'group' => [
        'created' => 'Groupe :name créer',
        'updated' => 'Groupe :name mis à jour',
        'banner_deleted' => 'Bannière du groupe :name supprimée avec succès',
        'banner_created' => 'Bannière du groupe :name ajoutée avec succès',
        'banner_updated' => 'Bannière du groupe :name mise à jour avec succès',
        'delete_banner_question' => 'Voulez-vous vraiment supprimer la bannière de ce groupe',
        'delete_banner' => 'Supprimer la bannière du groupe',
    ],

    'category' => [
        'created' => 'Catégorie :name créer',
        'updated' => 'Catégorie :name mise à jour',
        'banner_deleted' => 'Bannière de la catégorie :name supprimée avec succès',
        'banner_created' => 'Bannière de la catégorie :name ajoutée avec succès',
        'banner_updated' => 'Bannière de la catégorie :name mise à jour avec succès',
        'delete_banner_question' => 'Voulez-vous vraiment supprimer la bannière de cette catégorie',
        'delete_banner' => 'Supprimer la bannière de la catégorie',
    ],

    'attribute' => [
        'created' => 'Attribut :name créer',
        'updated' => 'Attribut :name mise à jour',
    ],

    'attribute-value' => [
        'created' => "Valeur d'attribut :name créer",
        'updated' => "Valeur d'attribut :name mise à jour",
    ],

    'state' => [
        'created' => 'Région :name créer',
        'updated' => 'Région :name mise à jour',
    ],

    'vendor' => [
        'created' => 'Fournisseur :name créer',
        'updated' => 'Fournisseur :name mis à jour',
        'logo_deleted' => 'Logo du fournisseur :name supprimé avec succès',
        'logo_created' => 'Logo du fournisseur :name ajouté avec succès',
        'logo_updated' => 'Logo du fournisseur :name mis à jour avec succès',
        'delete_logo_question' => 'Voulez-vous vraiment supprimer le logo de ce fournisseur',
        'delete_logo' => 'Supprimer le logo du fournisseur',
        'vendor_default_address_updated' => 'Adresse par défaut mise à jour avec succès',
        'vendor_default_address_created' => 'Adresse par défaut ajoutée avec succès',
    ],

    'coupon' => [
        'created' => 'Coupon :code créer',
        'updated' => 'Coupon :code mis à jour',
    ],

    'user' => [
        'merchant_created' => 'Marchand :name créer',
        'manager_created' => 'Gestionnaire de boutique :name créer',
        'seller_created' => 'Vendeur :name créer',
        'admin_created' => 'Administrateur :name créer',
        'avatar_deleted' => 'Avatar du membre :name supprimé avec succès',
        'avatar_created' => 'Avatar du membre :name ajouté avec succès',
        'avatar_updated' => 'Avatar du membre :name mis à jour avec succès',
        'delete_avatar_question' => "Voulez-vous vraiment supprimer l'avatar de ce membre",
        'delete_avatar' => "Supprimer l'avatar du membre",
    ],

    'footer' => [
        'copyright' => 'Copyright',
        'all_rights_reserved' => 'tous les droits réservés',
        'designed_by' => 'Design par',
    ],

    'gender' => [
        'male' => 'Masculin',
        'female' => 'Féminin',
        'unknown' => 'Inconnu',
    ],

];
