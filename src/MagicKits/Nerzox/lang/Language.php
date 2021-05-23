<?php

namespace MagicKits\Nerzox\lang;

interface Language {
    public CONST EN = [
        'PLUGIN_ENABLED' => "Plugin enabled!",
        'PLUGIN_DISABLED' => 'Plugin disabled!',
        'DESCRIPTION_COMMAND' => 'All the kits than you can use!',
        'USAGE_COMMAND' => '/kit [kit_name]',
        'NOT_A_PLAYER' => 'Please use this command in game.',
        'CANT_GIVE_KIT' => 'You have not the slots required for give this kit.',
        'KIT_GIVED' => 'You have received the kit.',
        'COOLDOWN_NOT_FINISHED' => "You have {days} day(s), {hours} hour(s), {minutes} minute(s) and {seconds} second(s) of cooldown to reuse this kit."
    ];
    public CONST FR = [
        'PLUGIN_ENABLED' => "Plugin allumé!",
        'PLUGIN_DISABLED' => 'Plugin éteint!',
        'DESCRIPTION_COMMAND' => 'Tous les kits que vous pouvez utiliser!',
        'USAGE_COMMAND' => '/kit [nom_du_kit]',
        'NOT_A_PLAYER' => 'Veuillez utiliser cette commande en jeu, s\'il vous plaît.',
        'CANT_GIVE_KIT' => 'Vous n\'avez pas la place requise dans votre inventaire pour donner ce kit.',
        'KIT_GIVED' => 'Vous avez bien reçu le kit.',
        'COOLDOWN_NOT_FINISHED' => "Il vous reste {days} jour(s), {hours} heure(s), {minutes} minute(s) et {seconds} secondes avant de pouvoir réutiliser ce kit."
    ];
}