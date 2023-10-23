#!/usr/bin/env python3
from pdf2image import convert_from_path
from zipfile import ZipFile
import os
import uuid

# Change an entire pdf to images based on image_type
def pdf_to_image(file_name, image_type):

	# Getting directory values from environment variables
	upload_path = os.environ.get('UPLOAD_FILES_PATH', '../uploads')
	temp_path = os.environ.get('TEMP_FILES_PATH', '../temp')
	result_path = os.environ.get('FINAL_FILES_PATH', '../final_results')

	# Convert the PDF to a list of PIL (Pillow) image objects
	images = convert_from_path(os.path.join(upload_path, file_name))
	images_name = []

	# Saving images in temp folder
	for i, image in enumerate(images):
		images_name.append(os.path.join(temp_path, file_name + "_" + str(i+1) + "_" + str(uuid.uuid4()) + "." + image_type.lower()))
		image.save(images_name[-1], image_type.upper())

	# Zipping all the generated images
	zip_file_name = file_name + '_' + str(uuid.uuid4()) + ".zip"
	with ZipFile(os.path.join(result_path, zip_file_name),'w') as zip:  
		for file in images_name: 
			zip.write(file, os.path.basename(file))

	# Removing Temporary files
	for image in images_name:
		os.remove(image)

	return zip_file_name