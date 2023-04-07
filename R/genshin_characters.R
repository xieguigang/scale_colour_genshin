const keys = function() {
    names(__get_inmemory_cache());
}

const scale_colour_genshin = function(name = scale_colour_genshin::keys()) {
    ggplot2::scale_colour_manual(character_colorSet(name));
}

const character_colorSet = function(name = "albedo") {
    const characters = __get_inmemory_cache();
    const chr_name = name[1] || stop("no character name was specificed!");
    const scale_colors = characters[[chr_name]];

    scale_colors;
}