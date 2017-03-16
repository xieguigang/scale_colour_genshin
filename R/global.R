# To assign in the global environment. A simpler, shorter (but not better ... stick with assign) way is to use the <<- operator, ie
#
#    a <<- "new"
#
# inside the function.

# Get current user's home directory
HOME <<- path.expand('~');
# and then combine this HOME directory for initialize this package's configuration data.
cfg <- sprintf("%s/GCModeller.cli2R.csv", HOME);
