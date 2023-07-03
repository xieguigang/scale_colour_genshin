require(ggplot);
require(JSON);

const .onLoad = function() {
    const env = globalenv();
    const palette = "data/scale_colour_genshin.json" 
    |> system.files(package = "scale_colour_genshin")
    |> readText()
    |> JSON::json_decode()
    ;

    #' use color palette for heatmap/ms-imaging/etc
    #' 
    #' 1. use the character name directly, example as: "albedo"
    #' 2. use the character name with genshin prefix, example as: "genshin:albedo"
    #'
    for(name in names(palette)) {
        grDevices::register.color_palette(name, colors = palette[[name]]);
        grDevices::register.color_palette(`genshin:${name}`, colors = palette[[name]]);
    }
    
    set(env, "scale_colours@genshin", palette);
}
