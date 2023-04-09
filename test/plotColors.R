require(ggplot);

pwd = @dir;
pixels = [`${pwd}/../genshin_characters/character_posts/fischl.jpg`]
|> readImage()
|> resizeImage([256,256])
|> rasterPixels()
;

print(pixels, max.print = 13);

bitmap(file = `${pwd}/raster.png`) {
    ggplot(pixels, aes(x = "r", y = "g", z = "b"), padding = "padding:250px 500px 100px 100px;")

    # use scatter points for visual our data
    + geom_point(shape = "triangle", size = 20)   
    + ggtitle("Raster Pixels")
    ;
}