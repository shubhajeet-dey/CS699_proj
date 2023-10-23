#!/usr/bin/env python3
from PyPDF2 import PdfWriter, PdfReader
import os
import uuid

# Encrypting/Decrypting the PDF
def encrypt_pdf(file_name, password, process_type):

	# Getting directory values from environment variables
	upload_path = os.environ.get('UPLOAD_FILES_PATH', '../uploads')
	temp_path = os.environ.get('TEMP_FILES_PATH', '../temp')
	result_path = os.environ.get('FINAL_FILES_PATH', '../final_results')

	reader = PdfReader(os.path.join(upload_path, file_name))
	writer = PdfWriter()

	# 0 means Encryption
	if process_type == 0 and not reader.is_encrypted:

		# Adding all pages to the writer
		for page in reader.pages:
			writer.add_page(page)

		# Adding the password
		writer.encrypt(password)

		# Writing the encrypted content into a PDF
		encrypt_pdf_name = file_name + "_encrypt_" + str(uuid.uuid4()) + ".pdf"
		writer.write(os.path.join(result_path, encrypt_pdf_name))
		writer.close()

		return encrypt_pdf_name

	# 1 means Decryption
	elif process_type == 1 and reader.is_encrypted:

		# Decrypting the content using the password
		reader.decrypt(password)

		# Adding all pages to the writer
		for page in reader.pages:
			writer.add_page(page)

		# Writing the decrypted content into a PDF
		decrypt_pdf_name = file_name + "_decrypt_" + str(uuid.uuid4()) + ".pdf"
		writer.write(os.path.join(result_path, decrypt_pdf_name))
		writer.close()

		return decrypt_pdf_name
	
	else:
		 raise Exception("Error handling files")
