setwd("C:\\Users\\xieguigang\\OneDrive\\1.23\\1. samples\\")
options(stringsAsFactors = FALSE) 

#scatter plot
raw<-read.csv("XT9_Scaffold-R2-raw.csv",header=TRUE)
#raw<-raw[raw[,4] == "Unambiguous",]
#raw<-raw[raw[,34] == "Use",]
#raw<-raw[raw[,2] == "High",]

#raw1<-read.csv("C-O.csv",header=TRUE)
#raw1<-raw1[raw1[,4] == "Unambiguous",]
#raw1<-raw1[raw1[,34] == "Use",]
#raw1<-raw1[raw1[,2] == "High",]

tiff("scatterplot2.tiff",width=6000,height=4500,res=550)
par(mfrow=c(3,3))

raw = data.frame(raw, stringsAsFactors = FALSE)

regression.plot <- function(sx, sy) {

xl <- paste("sample", sx)
yl <- paste("sample", sy)

x <- as.numeric(as.vector(raw[,sx]))
y <- as.numeric(as.vector(raw[,sy]))

plot(x,y, col="red",pch=4,xlab= xl, ylab=yl, main=paste(sx,"vs",sy))
fit <- lm(x~y)
abline(fit, col="black",lwd=2) # regression line (y~x) 
r2=paste("=",round(summary(fit)$adj.r.squared,4))
text(3/4*max(x, na.rm=T), 1/3*max(y, na.rm=T),bquote(R^2~.(r2)))
}

regression.plot("C1","C2")
regression.plot("C1","C3")
regression.plot("C2","C3")

regression.plot("D215.1","D215.2")
regression.plot("D215.1","D215.3")
regression.plot("D215.3","D215.2")

regression.plot("O363.1","O363.2")
regression.plot("O363.1","O363.3")
regression.plot("O363.3","O363.2")

# regression.plot("C3.C1","C2.C1")
# regression.plot("C3.C1","C2.C3")
# regression.plot("C2.C1","C2.C3")

# regression.plot("D215.2.D215.1","D215.3.D215.1")
# regression.plot("D215.2.D215.1","D215.3.D215.2")
# regression.plot("D215.3.D215.1","D215.3.D215.2")

# regression.plot("O363.1.O363.2","O363.3.O363.2")
# regression.plot("O363.1.O363.2","O363.3.O363.1")
# regression.plot("O363.3.O363.2","O363.3.O363.1")


# plot(raw[,"X115"],raw[,"X119"],col="red",pch=4,xlab="Peak area of 115", ylab="Peak area of 119", main="P-An")
# abline(lm(raw[,"X119"]~raw[,"X115"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw[,"X119"]~raw[,"X115"]))$adj.r.squared,4))
# text(3/4*max(raw[,"X115"],na.rm=T), 1/3*max(raw[,"X119"],na.rm=T),bquote(R^2~.(r2)))


# plot(raw[,"X117"],raw[,"X119"],col="red",pch=4,xlab="Peak area of 117", ylab="Peak area of 119", main="P-An")
# abline(lm(raw[,"X119"]~raw[,"X117"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw[,"X119"]~raw[,"X117"]))$adj.r.squared,4))
# text(3/4*max(raw[,"X117"],na.rm=T), 1/3*max(raw[,"X119"],na.rm=T),bquote(R^2~.(r2)))


# plot(raw[,"X116"],raw[,"X118"],col="red",pch=4,xlab="Peak area of 116", ylab="Peak area of 118", main="P-Ae")
# abline(lm(raw[,"X118"]~raw[,"X116"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw[,"X118"]~raw[,"X116"]))$adj.r.squared,4))
# text(3/4*max(raw[,"X116"],na.rm=T), 1/3*max(raw[,"X118"],na.rm=T),bquote(R^2~.(r2)))

# plot(raw[,"X116"],raw[,"X121"],col="red",pch=4,xlab="Peak area of 116", ylab="Peak area of 121", main="P-Ae")
# abline(lm(raw[,"X121"]~raw[,"X116"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw[,"X121"]~raw[,"X116"]))$adj.r.squared,4))
# text(3/4*max(raw[,"X116"],na.rm=T), 1/3*max(raw[,"X121"],na.rm=T),bquote(R^2~.(r2)))

# plot(raw[,"X118"],raw[,"X121"],col="red",pch=4,xlab="Peak area of 118", ylab="Peak area of 121", main="P-Ae")
# abline(lm(raw[,"X121"]~raw[,"X118"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw[,"X121"]~raw[,"X118"]))$adj.r.squared,4))
# text(3/4*max(raw[,"X118"],na.rm=T), 1/3*max(raw[,"X121"],na.rm=T),bquote(R^2~.(r2)))

# plot(raw1[,"X115"],raw1[,"X117"],col="red",pch=4,xlab="Peak area of 115", ylab="Peak area of 117", main="M-An")
# abline(lm(raw1[,"X117"]~raw1[,"X115"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw1[,"X117"]~raw1[,"X115"]))$adj.r.squared,4))
# text(3/4*max(raw1[,"X115"],na.rm=T), 1/3*max(raw1[,"X117"],na.rm=T),bquote(R^2~.(r2)))


# plot(raw1[,"X115"],raw1[,"X119"],col="red",pch=4,xlab="Peak area of 115", ylab="Peak area of 119", main="M-An")
# abline(lm(raw1[,"X119"]~raw1[,"X115"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw1[,"X119"]~raw1[,"X115"]))$adj.r.squared,4))
# text(3/4*max(raw1[,"X115"],na.rm=T), 1/3*max(raw1[,"X119"],na.rm=T),bquote(R^2~.(r2)))


# plot(raw1[,"X117"],raw1[,"X119"],col="red",pch=4,xlab="Peak area of 117", ylab="Peak area of 119", main="M-An")
# abline(lm(raw1[,"X119"]~raw1[,"X117"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw1[,"X119"]~raw1[,"X117"]))$adj.r.squared,4))
# text(3/4*max(raw1[,"X117"],na.rm=T), 1/3*max(raw1[,"X119"],na.rm=T),bquote(R^2~.(r2)))


# plot(raw1[,"X116"],raw1[,"X118"],col="red",pch=4,xlab="Peak area of 116", ylab="Peak area of 118", main="M-Ae")
# abline(lm(raw1[,"X118"]~raw1[,"X116"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw1[,"X118"]~raw1[,"X116"]))$adj.r.squared,4))
# text(3/4*max(raw1[,"X116"],na.rm=T), 1/3*max(raw1[,"X118"],na.rm=T),bquote(R^2~.(r2)))

# plot(raw1[,"X116"],raw1[,"X121"],col="red",pch=4,xlab="Peak area of 116", ylab="Peak area of 121", main="M-Ae")
# abline(lm(raw1[,"X121"]~raw1[,"X116"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw1[,"X121"]~raw1[,"X116"]))$adj.r.squared,4))
# text(3/4*max(raw1[,"X116"],na.rm=T), 1/3*max(raw1[,"X121"],na.rm=T),bquote(R^2~.(r2)))

# plot(raw1[,"X118"],raw1[,"X121"],col="red",pch=4,xlab="Peak area of 118", ylab="Peak area of 121", main="M-Ae")
# abline(lm(raw1[,"X121"]~raw1[,"X118"]), col="black",lwd=2) # regression line (y~x) 
# r2=paste("=",round(summary(lm(raw1[,"X121"]~raw1[,"X118"]))$adj.r.squared,4))
# text(3/4*max(raw1[,"X118"],na.rm=T), 1/3*max(raw1[,"X121"],na.rm=T),bquote(R^2~.(r2)))
dev.off()


# raw_P<-read.table(file="160309P_TargetProtein.txt",se="\t",header=TRUE)
# raw_M<-read.table(file="114_TargetProtein.txt",se="\t",header=TRUE)
# raw_P<-raw_P[raw_P[,"Master"] == "IsMasterProtein",]
# row.names(raw_P)<-raw_P[,"Accession"]
# raw_M<-raw_M[raw_M[,"Master"] == "IsMasterProtein",]
# row.names(raw_M)<-raw_M[,"Accession"]
# write.table(raw_P[intersect(raw_P[,"Accession"],raw_M[,"Accession"]),],file="P.txt",sep="\t",quote=FALSE);
# write.table(raw_M[intersect(raw_P[,"Accession"],raw_M[,"Accession"]),],file="M.txt",sep="\t",quote=FALSE);

# raw<-read.table(file="mw-pi.txt",sep="\t",header=TRUE,row.names=1,check.names=FALSE)
# tiff("pimw.tiff",width=2500,height=2000,res=400)
# plot(raw[,2],raw[,1],xlab="Calc.PI",ylab="MW[Kda]",pch=15)
# dev.off()

# raw<-read.table("ratio.txt",sep="\t",header=TRUE,row.names=1)
# png("density.png", 3000, 3000,res=350)
# par(mfrow=c(2,2))
# x<-log2(raw[,1])
# h<-hist(x, breaks=10,  xlab="log2(ratio P-An vs P-Ae)",main="P-An vs P-Ae",ylim=c(0,600)) 
# xfit<-seq(min(x)-1,max(x),length=20) 
# yfit<-dnorm(xfit,mean=mean(x),sd=sd(x)) 
# yfit <- yfit*diff(h$mids[1:2])*length(x) 
# lines(xfit, yfit, col="black", lwd=2)

# x<-log2(raw[,2])
# h<-hist(x, breaks=10,  xlab="log2(ratio M-An vs M-Ae)",main="M-An vs M-Ae",ylim=c(0,600)) 
# xfit<-seq(min(x)-1,max(x),length=20) 
# yfit<-dnorm(xfit,mean=mean(x),sd=sd(x)) 
# yfit <- yfit*diff(h$mids[1:2])*length(x) 
# lines(xfit, yfit, col="black", lwd=2)

# x<-log2(raw[,1])
# h<-hist(x, breaks=10,  xlab="log2(ratio M-An vs P-An)",main="M-An vs P-An",ylim=c(0,600)) 
# xfit<-seq(min(x)-1,max(x),length=20) 
# yfit<-dnorm(xfit,mean=mean(x),sd=sd(x)) 
# yfit <- yfit*diff(h$mids[1:2])*length(x) 
# lines(xfit, yfit, col="black", lwd=2)

# x<-log2(raw[,4])
# h<-hist(x, breaks=10,  xlab="log2(ratio M-Ae vs P-Ae)",main="M-Ae vs P-Ae",ylim=c(0,600)) 
# xfit<-seq(min(x)-1,max(x),length=20) 
# yfit<-dnorm(xfit,mean=mean(x),sd=sd(x)) 
# yfit <- yfit*diff(h$mids[1:2])*length(x) 
# lines(xfit, yfit, col="black", lwd=2)
# dev.off()


# allratio<-read.table(file="allratio.txt",sep="\t",header=TRUE,row.names=1)
# library(pheatmap)
# library(gplots)
# tiff("heatmap.tiff",width=3000,height=3000,res=500)
# pheatmap(allratio,scale="row",border=NA,color=greenred(100),show_rownames  =FALSE)
# dev.off()

# uniprot<-read.csv(file="uniprot.csv",row.names=1)
# library(pheatmap)
# ratio<-read.table(file="ratio.txt",sep="\t",header=TRUE,row.names=1)
# flags<-ratio[,1]>=1.5 | ratio[,1]<=1/1.5 | ratio[,2]>=1.5 | ratio[,2]<=1/1.5 | ratio[,3]>=1.5 | ratio[,3]<=1/1.5 | ratio[,4]>=1.5 | ratio[,4]<=1/1.5
# degnames<-row.names(allratio[row.names(allratio) %in% row.names(ratio[flags,]),])
# write.csv(cbind(allratio[degnames,],uniprot[degnames,]),)
# library(pheatmap)
# library(gplots)
# tiff("heatmap.tiff",width=3000,height=6000,res=200)
# pheatmap(allratio[,],scale="row",border=NA,color=greenred(100))
# dev.off()