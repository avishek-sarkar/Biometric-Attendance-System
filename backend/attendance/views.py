from django.http import HttpResponse
from django.views.decorators.csrf import csrf_exempt

# Create your views here.
def StudentRegister(request):
    return HttpResponse("Student Register Page")