#!/usr/bin/env python3
from PyPDF2 import PdfWriter, PdfReader
import os
import uuid

# Rotating Clockwise PDFs based on angle (0: 90, 1: 180, 2: 270)
def rotate_pdf(file_name, rotate_angle):

	# Getting directory values from environment variables
	upload_path = os.environ.get('UPLOAD_FILES_PATH', '../uploads')
	temp_path = os.environ.get('TEMP_FILES_PATH', '../temp')
	result_path = os.environ.get('FINAL_FILES_PATH', '../final_results')

	reader = PdfReader(os.path.join(upload_path, file_name))
	writer = PdfWriter()

	angle = {0: 90, 1: 180, 2: 270}

	# Adding rotated pages to writer
	for page_num in range(len(reader.pages)):
		writer.add_page(reader.pages[page_num].rotate(angle[rotate_angle]))

	# Writing the updated pages to a pdf
	rotated_pdf_name = file_name + "_rotated_" + str(uuid.uuid4()) + ".pdf"
	writer.write(os.path.join(result_path, rotated_pdf_name))
	writer.close()

	return rotated_pdf_name