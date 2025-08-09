from django.db import models
from django.utils import timezone

# Create your models here.
class TempRegistration(models.Model):
  name = models.CharField(max_length=50)
  roll = models.CharField(max_length=20, unique=True)
  reg = models.CharField(max_length=10, unique=True)
  session = models.CharField(max_length=20)
  email = models.EmailField(max_length=50, unique=True)
  phone = models.CharField(max_length=15, unique=True)
  password = models.CharField(max_length=100)
  verification_token = models.CharField(max_length=100, blank=True, null=True)
  is_verified = models.BooleanField(default=False)
  created_at = models.DateTimeField(auto_now_add=True)

  class Meta:
    verbose_name = "Temporary Registration"
    verbose_name_plural = "Temporary Registrations"
    db_table = 'temp_registration'
  def __str__(self):
    return f"{self.name} ({self.roll})"
  
class FingerprintData(models.Model):
  status = models.BooleanField(default=False)
  lastFingerId = models.IntegerField(default=0)
  startTime = models.DateTimeField(default=timezone.now)
  scanInterval = models.IntegerField(default=100)  # in seconds

  class Meta:
    verbose_name = "Fingerprint Data"
    verbose_name_plural = "Fingerprint Data"
    db_table = 'fingerprint_data'
  def __str__(self):
    return f"Fingerprint Data (Status: {'Active' if self.status else 'Inactive'})"
  
class StudentInfo(models.Model):
  student_name = models.CharField(max_length=50)
  student_roll = models.CharField(max_length=20, unique=True)
  student_reg = models.CharField(max_length=10, unique=True)
  student_session = models.CharField(max_length=20)
  student_email = models.EmailField(max_length=50, unique=True)
  student_phone = models.CharField(max_length=15, unique=True)
  password = models.CharField(max_length=100)
  finger_id = models.IntegerField(unique=True, null=True, blank=True)

  class Meta:
    verbose_name = "Student Info"
    verbose_name_plural = "Student Info"
    db_table = 'student_info'
  
  def __str__(self):
    return f"{self.student_name} ({self.roll})"