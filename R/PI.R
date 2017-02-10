library(tools) 

options(stringsAsFactors = FALSE) 

PI.plot <- function(csv) {

raw<-read.csv(file=csv,header=TRUE)
DIR <- dirname(csv)
DIR <- paste(DIR, file_path_sans_ext(basename(csv)), sep="/")

tiff(paste(DIR, "pimw.tiff", sep="-"),width=2500,height=2000,res=400)
plot(raw[,"calc..pI"],raw[,"MW..kDa."],xlab="Calc.PI",ylab="MW[Kda]",pch=15)
dev.off()

}

