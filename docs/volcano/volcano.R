require(ggplot);
require(Matrix);
require(scale_colour_genshin);

# load data
data(volcano);

volcano = as.matrix(volcano);
volcano = melt(volcano, varnames = c("X", "Y"), value_name = "Height");

print(volcano, max.print = 13);

let ggplot2 = function(genshin_colors) {
  p <- ggplot(volcano, aes(x = "X", y = "Y"),padding = "padding:10% 10% 10% 12%;") +
     geom_tile(aes(fill = "Height")) +
     scale_fill_distiller(palette = genshin_colors, direction = 1) +
     theme_light(
        axis.text = element_text(family = "Cambria Math", size = 20),
        axis.title = element_text(family = "Cambria Math", size = 36),
        legend.tick = element_text(family = "Cambria Math", size = 18)
     ) +
     labs(title = "Volcano Height Map");
  p;
}

for(let color_name in scale_colour_genshin::keys()) {
   png(filename = relative_work(`volcano_genshin_${color_name}.png`), 
      width = 600, 
      height = 400, 
      bg = "white");
      
   plot(ggplot2(`genshin:${color_name}`));
   dev.off();
}

