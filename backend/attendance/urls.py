from django.urls import path, include
from .views import *

urlpatterns = [
    # example below
    path('signup/', signup, name='signup'),
    path('attendance/', attendance, name='attendance'),
]
