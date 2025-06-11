require(ggplot);
require(JSON);

const .onLoad = function() {
    const env = globalenv();
    const palette = "data/scale_colour_genshin.json" 
    |> system.file(package = "scale_colour_genshin")
    |> readText()
    |> JSON::json_decode()
    ;

    print("load genshin names:");
    print(names(palette));

    #' use color palette for heatmap/ms-imaging/etc
    #' 
    #' 1. use the character name directly, example as: "albedo"
    #' 2. use the character name with genshin prefix, example as: "genshin:albedo"
    #'
    for(name in names(palette)) {
        grDevices::register.color_palette(name, palette = palette[[name]]);
        grDevices::register.color_palette(`genshin:${name}`, palette = palette[[name]]);
    }
    
    set(env, "scale_colours@genshin", palette);
}
