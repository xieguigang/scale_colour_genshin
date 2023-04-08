require(ggplot);

pwd = @dir;
img = readImage(`${pwd}/../genshin_characters/character_posts/fischl.jpg`);
pixels = rasterPixels(img);

print(pixels, max.print = 13);

bitmap(file = `${pwd}/raster.png`) {
    ggplot(pixels, aes(x = "r", y = "g", z = "b"), padding = "padding:250px 500px 100px 100px;")

    # use scatter points for visual our data
    + geom_point(shape = "triangle", size = 20)   
    + ggtitle("Raster Pixels")
    # use the default white theme from ggplot
    + theme_default()

    # use a 3d camera to rotate the charting plot 
    # and adjust view distance
    + view_camera(angle = [31.5,65,125], fov = 100000)
    ;
}