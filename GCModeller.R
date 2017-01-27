# GCModeller CLI to R binding

help.GCModeller <- function(tool = "GCModeller", man = 0) {
	
	CLI = paste(tool, "?")
	system(CLI)
	
}