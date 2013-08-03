# make
# gcc program.c -o program-output
#!/bin/sh
for png in `find ./themes/SCODB/images/$1 -name "*.png"`;
do
  echo "crushing $png"	
	optimizePNG/./pngcrush -brute "$png" temp.png
	mv -f temp.png $png
done;




# jpegtran
for jpg in `find $1 -iname "*.jpg"`; do
    echo "crushing $jpg ..."
    jpegtran -copy none -optimize -perfect "$jpg" > temp.jpg
 
    # preserve original on error
    if [ $? = 0 ]; then
        mv -f temp.jpg $jpg
    else
        rm temp.jpg
    fi
done
