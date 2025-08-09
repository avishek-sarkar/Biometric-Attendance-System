from django.urls import path, include
from .views import *

urlpatterns = [
    # example below
    path('StudentRegister/', StudentRegister, name='StudentRegister'),
]
